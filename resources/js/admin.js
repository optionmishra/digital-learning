import $ from "jquery";
window.$ = window.jQuery = $;
import toastr from "toastr";
import "datatables.net-dt";

/**
 * Admin Panel Management System
 * Handles CRUD operations, data tables, forms, and UI interactions
 */
class AdminPanel {
  constructor() {
    this.deleteBtn = null;
    this.deleteRoute = null;
    this.init();
  }

  /**
   * Initialize all event listeners and components
   */
  init() {
    this.bindEvents();
    this.initializeDataTables();
    this.initializeModals();
  }

  /**
   * Bind all event listeners
   */
  bindEvents() {
    // Delete operations
    document.addEventListener("click", this.handleDeleteClick.bind(this));
    this.bindDeleteConfirmations();

    // Update operations
    document.addEventListener("click", this.handleUpdateClick.bind(this));

    // Form submissions
    $(".modal form").on("submit", this.handleFormSubmit.bind(this));

    // Special form handlers
    $("#enableArticlesForm input").on(
      "change",
      this.handleEnableArticlesChange.bind(this),
    );

    // Button route handlers
    $(document).on(
      "click",
      "[data-btn-route]",
      this.handleButtonRoute.bind(this),
    );

    // Dropdown change handlers
    this.bindDropdownHandlers();

    // Image/source type handlers
    this.bindFileTypeHandlers();

    // Question store method handler
    this.questionStoreMethodHandler();
  }

  /**
   * DELETE OPERATIONS
   */
  handleDeleteClick(event) {
    this.deleteBtn = event.target.closest("[data-delete-route]");
    if (!this.deleteBtn) return;

    event.preventDefault();
    this.deleteRoute = this.deleteBtn.dataset.deleteRoute;
  }

  bindDeleteConfirmations() {
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
    const confirmDemoteBtn = document.getElementById("confirmDemoteBtn");

    if (confirmDeleteBtn) {
      confirmDeleteBtn.addEventListener("click", () => this.executeDelete());
    }

    if (confirmDemoteBtn) {
      confirmDemoteBtn.addEventListener("click", () => this.executeDelete());
    }
  }

  async executeDelete() {
    try {
      const response = await fetch(this.deleteRoute, {
        method: "DELETE",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
      });

      if (!response.ok) {
        throw new Error(response.statusText);
      }

      const data = await response.json();

      if (data.error) {
        toastr.error(data.message, "Admin Panel");
      } else {
        toastr.success(data.message, "Admin Panel");
        $(".dataTable").DataTable().draw();
      }
    } catch (error) {
      toastr.error("Something went wrong!", "Admin Panel");
      console.error("Error:", error);
    }
  }

  /**
   * UPDATE OPERATIONS
   */
  handleUpdateClick(event) {
    const el =
      event.target.closest("[data-row-data]") ||
      event.target.closest("[data-restricted-permissions]");

    if (!el) return;

    event.preventDefault();
    const updateRoute = el.dataset.updateRoute;
    let rowData = {};

    if (el.dataset.rowData) {
      rowData = JSON.parse(el.dataset.rowData);
    }

    // Make this async to handle the async populateUpdateForm
    this.populateUpdateForm(updateRoute, rowData).catch((error) => {
      console.error("Error populating update form:", error);
      toastr.error("Error loading form data", "Admin Panel");
    });
  }

  async populateUpdateForm(updateRoute, rowData) {
    const form = document.getElementById("updateDataForm");
    form.setAttribute("action", updateRoute);

    // Process form fields sequentially to handle dependencies
    const formFields = Array.from(document.querySelectorAll("form [name]"));

    for (const el of formFields) {
      if (el.name in rowData) {
        await this.setFormFieldValue(el, rowData);
      }
    }
  }

  async setFormFieldValue(element, rowData) {
    const fieldName = element.name;
    const value = rowData[fieldName];

    switch (fieldName) {
      case "correct_option":
        this.setRadioValue(fieldName, value);
        break;

      case "books[]":
        this.setCheckboxValues(fieldName, value);
        break;

      case "subject_id":
        await this.updateSeries(value);
        await this.updateBooks(
          rowData["standard_id"],
          value,
          rowData["series_id"],
        );
        element.value = value;
        break;

      case "series_id":
        await this.updateBooks(
          rowData["standard_id"],
          rowData["subject_id"],
          value,
        );
        element.value = value;
        break;

      case "book_id":
        await this.updateTopics(value);
        element.value = value;
        // If topic_id exists in rowData, set it after books are loaded
        if ("topic_id" in rowData) {
          const topicSelect = document.getElementById("topic");
          if (topicSelect) {
            topicSelect.value = rowData["topic_id"];
          }
        }
        break;

      case "topic_id":
        // Skip setting topic_id here as it's handled in book_id case
        // This prevents setting the value before topics are loaded
        break;

      default:
        element.value = value;
        break;
    }
  }

  setRadioValue(fieldName, value) {
    Array.from(document.querySelectorAll(`input[name="${fieldName}"]`)).forEach(
      (radio) => {
        radio.checked = radio.value == value;
      },
    );
  }

  setCheckboxValues(fieldName, values) {
    values.forEach((value) => {
      Array.from(
        document.querySelectorAll(
          `input[name="${fieldName}"][value="${value}"]`,
        ),
      ).forEach((checkbox) => {
        checkbox.checked = true;
      });
    });
  }

  /**
   * FORM OPERATIONS
   */
  handleFormSubmit(event) {
    event.preventDefault();

    const form = $(event.target);
    this.toggleLoading(true);

    const formData = {
      url: form.attr("action"),
      method: form.attr("method"),
      reload: form.attr("reload"),
      data: new FormData(event.target),
    };

    this.submitForm(form, formData);
  }

  async submitForm(form, formData) {
    try {
      const response = await $.ajax({
        url: formData.url,
        type: formData.method,
        data: formData.data,
        contentType: false,
        processData: false,
      });

      this.handleFormResponse(form, response, formData.reload);
    } catch (error) {
      this.handleFormError(error);
    } finally {
      this.toggleLoading(false);
    }
  }

  handleFormResponse(form, data, reload) {
    if (data.error) {
      toastr.error(data.message, "Admin Panel");
    } else {
      toastr.success(data.message, "Admin Panel");
      this.resetForm(form);
      $(".modal").modal("hide");

      if (reload === "true") {
        location.reload();
      }

      $(".dataTable").DataTable().draw();
    }
  }

  handleFormError(error) {
    toastr.error(
      error.responseJSON?.message || "Something went wrong!",
      "Admin Panel",
    );
    console.error("Error:", error);
  }

  resetForm(form) {
    if (form.parents(".modal").length > 0) {
      form[0].reset();
      this.clearHiddenFields();
    }
  }

  clearHiddenFields() {
    const hiddenInputs = document.querySelectorAll('form input[type="hidden"]');
    hiddenInputs.forEach((input) => {
      if (input.name !== "_token") {
        input.value = "";
      }
    });
  }

  toggleLoading(show) {
    $("#loading").toggleClass("d-none", !show);
    $("body").css("overflow", show ? "hidden" : "auto");
  }

  /**
   * SPECIAL FORM HANDLERS
   */
  async handleEnableArticlesChange(event) {
    const form = $(event.target).closest("form");
    const formData = new FormData(form[0]);
    formData.append("enableArticles", $(event.target).is(":checked"));

    try {
      const response = await fetch(form.attr("action"), {
        method: form.attr("method"),
        body: formData,
      });

      const data = await response.json();

      if (data.error) {
        toastr.error(data.message, "Admin Panel");
      } else {
        toastr.success(data.message, "Admin Panel");
      }
    } catch (error) {
      toastr.error("Something went wrong!", "Admin Panel");
      console.error("Error:", error);
    }
  }

  handleButtonRoute(event) {
    const button = $(event.currentTarget);
    const route = button.data("btn-route");
    const formId = button.data("form");

    if (!route || !formId) {
      console.warn("Missing required data attributes");
      return;
    }

    const form = document.getElementById(formId);
    if (form) {
      form.setAttribute("action", route);
    } else {
      console.warn(`Form with ID '${formId}' not found`);
    }
  }

  /**
   * DROPDOWN MANAGEMENT
   */
  bindDropdownHandlers() {
    // Category topics
    $("#categoryPostCategory").on(
      "change",
      this.handleCategoryChange.bind(this),
    );

    // Standard-Subject-Series-Book-Topic chain
    const chainSets = [
      {
        standard: "standard",
        subject: "subject",
        series: "series",
        book: "book",
      },
    ];

    chainSets.forEach(({ standard, subject, series, book }) => {
      const standardSelect = document.getElementById(standard);
      const subjectSelect = document.getElementById(subject);
      const seriesSelect = document.getElementById(series);
      const bookSelect = document.getElementById(book);

      const updateBooksAndTopics = async () => {
        await this.updateBooks();
        await this.updateTopics();
      };

      const updateSeriesAndBooks = async () => {
        await this.updateSeries();
        await this.updateBooks();
        await this.updateTopics();
      };

      if (standardSelect) {
        standardSelect.addEventListener("change", updateBooksAndTopics);
      }

      if (subjectSelect) {
        subjectSelect.addEventListener("change", updateSeriesAndBooks);
      }

      if (seriesSelect) {
        seriesSelect.addEventListener("change", updateBooksAndTopics);
      }

      if (bookSelect) {
        bookSelect.addEventListener("change", () => this.updateTopics());
      }
    });
  }

  async handleCategoryChange(event) {
    const selected = $(event.target).find("option:selected");
    const url = selected.data("topics-route");
    const topicSelect = document.getElementById("categoryPostTopic");

    if (!topicSelect || !url) return;

    // Clear existing options
    topicSelect.innerHTML = "";

    try {
      const response = await fetch(url);
      const data = await response.json();

      if (data.length > 0) {
        data.forEach((option) => {
          const optionElement = document.createElement("option");
          optionElement.value = option.id;
          optionElement.textContent = option.name;
          topicSelect.appendChild(optionElement);
        });
      } else {
        const optionElement = document.createElement("option");
        optionElement.value = "";
        optionElement.textContent = "No topics found for this category!";
        topicSelect.appendChild(optionElement);
      }
    } catch (error) {
      console.error("Error fetching topics:", error);
      topicSelect.innerHTML = "<option value=''>Error loading topics</option>";
    }
  }

  async updateBooks(standardId, subjectId, seriesId) {
    const standardSelect = document.getElementById("standard");
    const subjectSelect = document.getElementById("subject");
    const seriesSelect = document.getElementById("series");
    const bookSelect = document.getElementById("book");

    if (!bookSelect) return;

    if (!standardId && standardSelect) standardId = standardSelect.value;
    if (!subjectId && subjectSelect) subjectId = subjectSelect.value;
    if (!seriesId && seriesSelect) seriesId = seriesSelect.value;

    bookSelect.innerHTML = "<option value=''>Loading...</option>";

    try {
      let url = `/api/books?standard_ids=${standardId}&subject_ids=${subjectId}`;
      if (seriesId) {
        url += `&series_ids=${seriesId}`;
      }

      const response = await fetch(url);
      const books = await response.json();

      if (books.data.length == 0) {
        bookSelect.disabled = true;
        bookSelect.innerHTML = "<option value=''>No Books Found</option>";
        return;
      }
      bookSelect.innerHTML = "";
      bookSelect.disabled = false;
      books.data.forEach((book) => {
        const option = document.createElement("option");
        option.value = book.id;
        option.textContent = book.name;
        bookSelect.appendChild(option);
      });
    } catch (error) {
      console.error("Error fetching books:", error);
      bookSelect.innerHTML = "<option value=''>Error loading books</option>";
    }
  }

  async updateSeries(subjectId) {
    const subjectSelect = document.getElementById("subject");
    const seriesSelect = document.getElementById("series");

    if (!seriesSelect) return;

    if (!subjectId && subjectSelect) subjectId = subjectSelect.value;
    if (!subjectId) {
      seriesSelect.disabled = true;
      seriesSelect.innerHTML = "<option value=''>No Subject Selected</option>";
      return;
    }

    seriesSelect.innerHTML = "<option value=''>Loading...</option>";

    try {
      const response = await fetch(`/api/series?subject_ids=${subjectId}`);
      const series = await response.json();

      if (series.data.length == 0) {
        seriesSelect.disabled = true;
        seriesSelect.innerHTML = "<option value=''>No Series Found</option>";
        return;
      }

      seriesSelect.innerHTML = "";
      seriesSelect.disabled = false;
      series.data.forEach((serie) => {
        const option = document.createElement("option");
        option.value = serie.id;
        option.textContent = serie.name;
        seriesSelect.appendChild(option);
      });
    } catch (error) {
      console.error("Error fetching series:", error);
      seriesSelect.innerHTML = "<option value=''>Error loading series</option>";
    }
  }

  async updateTopics(bookId) {
    const bookSelect = document.getElementById("book");
    const topicSelect = document.getElementById("topic");

    if (!topicSelect) return;

    if (!bookId && bookSelect) bookId = bookSelect.value;
    if (!bookId) {
      topicSelect.disabled = true;
      topicSelect.innerHTML = "<option value=''>No Books Selected</option>";
      return;
    }

    topicSelect.innerHTML = "<option value=''>Loading...</option>";

    try {
      const response = await fetch(`/api/topics/${bookId}`);
      const topics = await response.json();

      if (topics.data.length == 0) {
        topicSelect.disabled = true;
        topicSelect.innerHTML = "<option value=''>No Topics Found</option>";
        return;
      }

      topicSelect.innerHTML = "";
      topicSelect.disabled = false;
      topics.data.forEach((topic) => {
        const option = document.createElement("option");
        option.value = topic.id;
        option.textContent = topic.name;
        topicSelect.appendChild(option);
      });
    } catch (error) {
      console.error("Error fetching topics:", error);
      topicSelect.innerHTML = "<option value=''>Error loading topics</option>";
    }
  }

  /**
   * FILE TYPE HANDLERS
   */
  bindFileTypeHandlers() {
    $("#img_type").on("change", (e) => this.handleFileTypeChange(e, "img"));
    $("#src_type").on("change", (e) => this.handleFileTypeChange(e, "src"));
  }

  handleFileTypeChange(event, type) {
    const isUrl = $(event.target).val() === "url";
    const urlContainer = $(`#${type}UrlInputContainer`);
    const fileContainer = $(`#${type}FileInputContainer`);

    if (isUrl) {
      urlContainer.removeClass("d-none").find("input").prop("disabled", false);
      fileContainer.addClass("d-none").find("input").prop("disabled", true);
    } else {
      urlContainer.addClass("d-none").find("input").prop("disabled", true);
      fileContainer.removeClass("d-none").find("input").prop("disabled", false);
    }
  }

  questionStoreMethodHandler() {
    $("#create-question").on("click", function (e) {
      $(".batch-question").hide();
      $(".single-question").show();
      const form = $(".question-store-form");
      const actionUrl = form.data("single-route");
      form.attr("action", actionUrl);
    });
    $("#create-multiple-question").on("click", function (e) {
      $(".single-question").hide();
      $(".batch-question").show();
      const form = $(".question-store-form");
      const actionUrl = form.data("batch-route");
      form.attr("action", actionUrl);
    });
  }

  /**
   * MODAL MANAGEMENT
   */
  initializeModals() {
    // Reset forms when modals are hidden
    $(".modal").on("hide.coreui.modal", () => {
      $(".modal form").trigger("reset");
      this.clearHiddenFields();
    });

    // Handle modal shown event
    $(".modal").on("shown.coreui.modal", this.handleModalShown.bind(this));
  }

  handleModalShown() {
    const self = this;
    // Set initial file type states
    ["img", "src"].forEach((type) => {
      const typeSelect = $(`#${type}_type`);
      if (typeSelect.length) {
        self.handleFileTypeChange({ target: typeSelect[0] }, type);
      }
    });
  }

  /**
   * DATA TABLE MANAGEMENT
   */
  initializeDataTables() {
    const self = this;
    $("[data-table-route]").each(function (index, element) {
      const table = $(element);
      const route = table.attr("data-table-route");
      const columns = self.buildTableColumns(table);

      table.DataTable({
        language: {
          zeroRecords: "No record(s) found.",
        },
        processing: true,
        serverSide: true,
        lengthChange: true,
        order: [0, "asc"],
        searchable: true,
        bStateSave: false,
        ajax: {
          url: route,
          data: function (d) {
            // Additional data can be added here
          },
        },
        columns: columns,
      });
    });
  }

  buildTableColumns(table) {
    const self = this;
    return table
      .find("th")
      .map(function () {
        const headerText = $(this).text();
        return {
          data: self.getColumnDataName(headerText),
          name: headerText,
          searchable: headerText !== "#" && headerText !== "Actions",
          orderable: headerText !== "Actions",
          defaultContent: "NA",
        };
      })
      .get();
  }

  getColumnDataName(headerText) {
    const columnMap = {
      "#": "serial",
      Board: "board_name",
      Standard: "standard_name",
      Subject: "subject_name",
      Series: "series_name",
      Book: "book_name",
      Topic: "topic_name",
      Assessment: "assessment_name",
      Author: "author_name",
      "Teacher Code": "teacherCode",
      "Student Code": "studentCode",
      "Serial No.": "serialNo",
      "Start Date": "start_date",
      "End Date": "end_date",
    };

    return columnMap[headerText] || headerText.toLowerCase();
  }
}

// Initialize the admin panel when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
  new AdminPanel();
});
