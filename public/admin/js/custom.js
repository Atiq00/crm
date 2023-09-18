let setCkEditor = function(elem) {

    let editor;
    ClassicEditor.create( elem,
        {
            
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    'alignment',
                    '|',
                    'indent',
                    'outdent',
                    '|',
                    'codeBlock',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'undo',
                    'redo'
                ]
            },
            language: 'en',
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:full',
                    'imageStyle:side'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            }
        }
    ).then( newEditor => {
        editor = newEditor;
        handleStatusChanges( editor );
    } );

    function handleStatusChanges( editor ) {
        editor.model.document.on( 'change:data', () => {
            $(elem).val(editor.getData());
        } );
    }
    
}
