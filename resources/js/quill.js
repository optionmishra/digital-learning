import Quill from "quill";
import "quill/dist/quill.snow.css";

// const quill = new Quill("#editor", {
//     modules: {
//         toolbar: [
//             [{ header: [1, 2, false] }],
//             ["bold", "italic", "underline", "strike", "blockquote"],
//             [
//                 { list: "ordered" },
//                 { list: "bullet" },
//                 { indent: "-1" },
//                 { indent: "+1" },
//             ],
//             ["link", "image"],
//             ["clean"],
//         ],
//     },
//     placeholder: "Compose an epic...",
//     theme: "snow",
// });

const editors = document.querySelectorAll(".editor");
editors?.forEach((editor) => {
    const quill = new Quill(`#${editor.id}`, { theme: "snow" });
    $(".modal").on("shown.coreui.modal", function () {
        quill.root.innerHTML = $(`#hidden_${editor.id}`).val();
        quill.on("text-change", function (delta, oldDelta, source) {
            $(`#hidden_${editor.id}`).val(quill.root.innerHTML);
        });
    });
});
