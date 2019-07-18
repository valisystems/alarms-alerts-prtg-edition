tinymce.PluginManager.add('clientcode', function(editor, url) {
    // Add a button that opens a window
    editor.addButton('clientcode', {
        text: '<>',
        icon: false,
        onclick: function() {
            editor.insertContent('<p><pre><code>code...</code></pre></p>');
        }
    });
});