let easyMDE = null;
document.addEventListener("DOMContentLoaded", function() {
     easyMDE = new EasyMDE({
        toolbar: [
            {
                name: "bold",
                action: EasyMDE.toggleBold,
                title: "Bold",
            },
            {
                name: "italic",
                action: EasyMDE.toggleItalic,
                title: "Bold",
            },
            {
                name: "heading",
                action: EasyMDE.toggleHeadingSmaller,
                title: "Heading",
            },
            {
                name: "strikethrough",
                action: EasyMDE.toggleStrikethrough,
                title: "Strikethrough",
            },
            {
                name: "code",
                action: EasyMDE.toggleCodeBlock,
                title: "Code",
            },
            {
                name: "unordered-list",
                action: EasyMDE.toggleUnorderedList,
                title: "Generic List",
            },
            {
                name: "ordered-list",
                action: EasyMDE.toggleOrderedList,
                title: "Numbered List",
            },
            {
                name: "link",
                action: EasyMDE.drawLink,
                title: "Create Link",
            },
            {
                name: "table",
                action: EasyMDE.drawTable,
                title: "Insert Table",
            },
            {
                name: "quote",
                action: EasyMDE.toggleBlockquote,
                title: "Insert Blockquote",
            },
        ],
        element: document.getElementById('editor'),
    });
});

function sendToLivewire() {
    Livewire.dispatch('updateMarkdown', {values: easyMDE.value()});
}
