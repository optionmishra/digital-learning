import $ from "jquery";
window.$ = window.jQuery = $;
import toastr from "toastr";
import "datatables.net-dt";

document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("click", handleDeleteClick);

    var deleteBtn;
    var deleteRoute;

    function handleDeleteClick(event) {
        deleteBtn = event.target.closest("[data-delete-route]");
        if (!deleteBtn) return;
        event.preventDefault();
        deleteRoute = deleteBtn.dataset.deleteRoute;
    }

    // Block User
    // const confirmBlockBtn = document.getElementById("confirmBlockBtn");
    // if (confirmBlockBtn) {
    //     confirmBlockBtn.addEventListener("click", () => {
    //         fetch(deleteRoute, {
    //             method: "post",
    //             headers: {
    //                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
    //                     "content"
    //                 ),
    //             },
    //         })
    //             .then((response) => {
    //                 if (response.ok) {
    //                     return response.json();
    //                 } else {
    //                     throw new Error(response.statusText);
    //                 }
    //             })
    //             .then((data) => {
    //                 if (data.error == true) {
    //                     toastr.error(data.message, "Admin Panel");
    //                 } else {
    //                     toastr.success(data.message, "Admin Panel");
    //                     $(".dataTable").DataTable().draw();
    //                 }
    //             })
    //             .catch((error) => {
    //                 toastr.error("Something went wrong!", "Admin Panel");
    //                 console.error("Error:", error);
    //             });
    //     });
    // }

    // Delete
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener("click", () => {
            deleteRow();
        });
    }

    const confirmDemoteBtn = document.getElementById("confirmDemoteBtn");
    if (confirmDemoteBtn) {
        confirmDemoteBtn.addEventListener("click", () => {
            deleteRow();
        });
    }
    function deleteRow() {
        fetch(deleteRoute, {
            method: "delete",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        })
            .then((response) => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error(response.statusText);
                }
            })
            .then((data) => {
                if (data.error == true) {
                    toastr.error(data.message, "Admin Panel");
                } else {
                    toastr.success(data.message, "Admin Panel");
                    $(".dataTable").DataTable().draw();
                }
            })
            .catch((error) => {
                toastr.error("Something went wrong!", "Admin Panel");
                console.error("Error:", error);
            });
    }

    // Update
    document.addEventListener("click", function (e) {
        const el =
            e.target.closest("[data-row-data]") ||
            e.target.closest("[data-restricted-permissions]");
        if (!el) return;
        e.preventDefault();
        const updateRoute = el.dataset.updateRoute;

        let rowData;
        if (el.dataset.rowData) {
            rowData = JSON.parse(el.dataset.rowData);
        }
        const form = document.getElementById("updateDataForm");
        form.setAttribute("action", updateRoute);

        // if (rowData.length > 0) {
        Array.from(document.querySelectorAll("form [name]")).forEach((el) => {
            if (el.name in rowData) {
                if (el.name == "correct_option") {
                    const correctOption = rowData[el.name];
                    Array.from(
                        document.querySelectorAll(`input[name="${el.name}"]`)
                    ).forEach((radio) => {
                        if (radio.value == correctOption) {
                            radio.checked = true;
                        }
                    });
                }
                if (el.name == "books[]") {
                    const bookIds = rowData[el.name];
                    bookIds.forEach((bookId) => {
                        Array.from(
                            document.querySelectorAll(
                                `input[name="${el.name}"][value="${bookId}"]`
                            )
                        ).forEach((checkbox) => {
                            checkbox.checked = true;
                        });
                    });
                } else {
                    el.value = rowData[el.name];
                }
            }
        });
        // }
    });

    $("#enableArticlesForm input").on("change", function () {
        const form = $(this).closest("form");
        const route = form.attr("action");
        const method = form.attr("method");
        const formData = new FormData(form[0]);
        formData.append("enableArticles", $(this).is(":checked"));

        fetch(route, {
            method: method,
            body: formData,
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.error == true) {
                    toastr.error(data.message, "Admin Panel");
                } else {
                    toastr.success(data.message, "Admin Panel");
                }
            });
    });

    // Submit form
    $(".modal form").on("submit", function (e) {
        $("#loading").toggleClass("d-none");
        $("body").css("overflow", "hidden");
        e.preventDefault();
        const form = $(this);
        const submitUrl = form.attr("action");
        const method = form.attr("method");
        const reload = form.attr("reload");
        const formData = new FormData(this);

        $.ajax({
            url: submitUrl,
            type: method,
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#loading").toggleClass("d-none");
                $("body").css("overflow", "auto");
                if (data.error == true) {
                    toastr.error(data.message, "Admin Panel");
                } else {
                    toastr.success(data.message, "Admin Panel");
                    if (form.parents(".modal").length > 0) {
                        form[0].reset();
                        const hiddenInputs = document.querySelectorAll(
                            'form input[type="hidden"]'
                        );
                        hiddenInputs.forEach((input) => {
                            if (input.name !== "_token") {
                                input.value = ""; // Clears hidden fields
                            }
                        });
                    }
                    $(".modal").modal("hide");
                    if (reload == "true") {
                        location.reload();
                    }
                    $(".dataTable").DataTable().draw();
                }
            },
            error: function (error) {
                $("#loading").toggleClass("d-none");
                $("body").css("overflow", "auto");
                toastr.error(error.responseJSON.message, "Admin Panel");
                console.error("Error:", error);
            },
        });
    });

    // Reset form on modal hidden
    $(".modal").on("hide.coreui.modal", function () {
        $(this).find("form").trigger("reset");
        const hiddenInputs = document.querySelectorAll(
            'form input[type="hidden"]'
        );
        hiddenInputs.forEach((input) => {
            if (input.name !== "_token") {
                input.value = ""; // Clears hidden fields
            }
        });
    });

    // DataTable
    $("[data-table-route]").each(function (e) {
        const table = $(this);
        const route = table.attr("data-table-route");

        const columns = $(this)
            .find("th")
            .map(function (val, index) {
                return {
                    data:
                        $(this).text() === "#"
                            ? "serial"
                            : $(this).text() === "Board"
                            ? "board_name"
                            : $(this).text() === "Standard"
                            ? "standard_name"
                            : $(this).text() === "Subject"
                            ? "subject_name"
                            : $(this).text() === "Book"
                            ? "book_name"
                            : $(this).text() === "Topic"
                            ? "topic_name"
                            : $(this).text() === "Assessment"
                            ? "assessment_name"
                            : $(this).text().toLowerCase(),
                    name: $(this).text(),
                    searchable:
                        $(this).text() !== "#" && $(this).text() !== "Actions",
                    orderable: $(this).text() !== "Actions",
                    defaultContent: "NA",
                };
            });

        $("[data-table-route]").DataTable({
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
                data: function (d) {},
            },
            columns: columns,
        });
    });

    // Reset User's Password
    $(document).on("click", "[data-btn-route]", function (e) {
        const route = $(this).data("btn-route");
        const formId = $(this).data("form");
        const form = document.getElementById(formId);
        form.setAttribute("action", route);
        // fetch(route)
        //     .then((res) => res.json())
        //     .then((data) => {
        //         if (data.error == true) {
        //             toastr.error(data.message, "Admin Panel");
        //         } else {
        //             toastr.success(data.message, "Admin Panel");
        //         }
        //     });
    });

    // Category Topics Options
    $("#categoryPostCategory").on("change", function () {
        // Get selected option element
        const selected = $(this).find("option:selected");
        const url = selected.data("topics-route");
        const el = document.getElementById("categoryPostTopic");
        // Remove existing options
        while (el.firstChild) {
            el.removeChild(el.firstChild);
        }
        fetch(url)
            .then((res) => res.json())
            .then((data) => {
                // Add new options
                if (data.length > 0) {
                    data.forEach((option) => {
                        const optionElement = document.createElement("option");
                        optionElement.value = option.id;
                        optionElement.textContent = option.name;
                        el.appendChild(optionElement);
                    });
                } else {
                    const optionElement = document.createElement("option");
                    optionElement.value = "";
                    optionElement.textContent =
                        "No topics found for this category!";
                    el.appendChild(optionElement);
                }
            });
    });

    $("#img_type").on("change", function (e) {
        if ($(this).val() == "url") {
            $("#imgUrlInputContainer").removeClass("d-none");
            $("#imgFileInputContainer").addClass("d-none");
        } else {
            $("#imgUrlInputContainer").addClass("d-none");
            $("#imgFileInputContainer").removeClass("d-none");
        }
    });

    $(".modal").on("shown.coreui.modal", function () {
        if ($("#img_type").val() == "url") {
            $("#imgUrlInputContainer").removeClass("d-none");
            $("#imgFileInputContainer").addClass("d-none");
        } else {
            $("#imgUrlInputContainer").addClass("d-none");
            $("#imgFileInputContainer").removeClass("d-none");
        }
    });

    $("#src_type").on("change", function (e) {
        if ($(this).val() == "url") {
            $("#srcUrlInputContainer").removeClass("d-none");
            $("#srcFileInputContainer").addClass("d-none");
        } else {
            $("#srcUrlInputContainer").addClass("d-none");
            $("#srcFileInputContainer").removeClass("d-none");
        }
    });

    $(".modal").on("shown.coreui.modal", function () {
        if ($("#src_type").val() == "url") {
            $("#srcUrlInputContainer").removeClass("d-none");
            $("#srcFileInputContainer").addClass("d-none");
        } else {
            $("#srcUrlInputContainer").addClass("d-none");
            $("#srcFileInputContainer").removeClass("d-none");
        }
    });

    // DOMContentLoaded
});
