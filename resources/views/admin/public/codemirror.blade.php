
<link href="//cdn.bootcss.com/codemirror/5.27.4/codemirror.min.css" rel="stylesheet">
<script src="//cdn.bootcss.com/codemirror/5.27.4/codemirror.js"></script>
<script src="https://cdn.bootcss.com/codemirror/5.27.4/addon/selection/active-line.min.js"></script>
<script src="//cdn.bootcss.com/codemirror/5.27.4/addon/edit/matchbrackets.min.js"></script>
<script src="//cdn.bootcss.com/codemirror/5.27.4/addon/comment/continuecomment.min.js"></script>
<script src="//cdn.bootcss.com/codemirror/5.27.4/addon/comment/comment.min.js"></script>
<script src="//cdn.bootcss.com/codemirror/5.27.4/mode/javascript/javascript.min.js"></script>
<script src="https://cdn.bootcss.com/codemirror/5.27.4/addon/display/placeholder.min.js"></script>
<script src="https://cdn.bootcss.com/codemirror/5.27.4/addon/display/autorefresh.min.js"></script>
<script src="https://cdn.bootcss.com/js-beautify/1.6.14/beautify.min.js"></script>
<script>
    function codeMirrorEditor($obj) {
        return $($obj).each(function (i, item) {
            this.editor = CodeMirror.fromTextArea(this, {
                matchBrackets: true,
                lineNumbers: true,
                collapsed: true,
                lineWrapping: true,
                styleActiveLine: true,
                autoCloseBrackets: true,
                mode: 'application/ld+json',
            });
            this.editor.setSize($(this).outerWidth(), (parseInt(this.getAttribute('rows')) + 1) * 16.8);
            this.editor.on('change', function (cm) {
                cm.save();
            });
        });
    }
</script>
