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

const quill1 = new Quill("#content", {
    theme: "snow",
});
$(".modal").on("shown.coreui.modal", function () {
    quill1.root.innerHTML = $("#hiddenContent").val();
    quill1.on("text-change", function (delta, oldDelta, source) {
        $("#hiddenContent").val(quill1.root.innerHTML);
    });
});
