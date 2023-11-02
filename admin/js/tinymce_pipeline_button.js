(function() {
    tinymce.PluginManager.add('comoPipelineButton', function( editor, url ) {
        editor.addButton( 'comoPipelineButton', {
            text: tinyMCE_pipeline.button_name,
            icon: false,
            onclick: function() {
				var catOptions = jQuery.parseJSON(tinyMCE_pipeline.candidate_category_select_options);
				var typeOptions = jQuery.parseJSON(tinyMCE_pipeline.candidate_type_select_options);
				var methodOptions = jQuery.parseJSON(tinyMCE_pipeline.candidate_method_select_options);
				editor.windowManager.open( {
					title: tinyMCE_pipeline.button_title,
					body: [
                        {
                            type: 'textbox',
                            name: 'id',
                            label: 'Pipeline ID',
                            value: ''
                        },
						{
                            type   : 'listbox',
                            name   : 'category',
                            label  : 'Candidate Category',
                            values : catOptions
                        },
						{
                            type   : 'listbox',
                            name   : 'type',
                            label  : 'Candidate Type',
                            values : typeOptions
                        },
						{
                            type   : 'listbox',
                            name   : 'type',
                            label  : 'Candidate Method',
                            values : methodOptions
                        },
						{
                            type   : 'textbox',
                            name   : 'template',
                            label  : 'Template',
                            value  : ''
                        },
						{
                            type   : 'textbox',
                            name   : 'footnote',
                            label  : 'Footnote',
                            value  : ''
                        }
                    ],
                    onsubmit: function( e ) {
						var id = (e.data.id ? ' id='+e.data.id : '');
						var category = (e.data.category ? ' category='+e.data.category : '');
						var type = (e.data.type ? ' type='+e.data.type : '');
						var method = (e.data.method ? ' type='+e.data.method : '');
						var template = (e.data.template ? ' loop-template='+e.data.template : '');
						var footnote = (e.data.footnote ? ' footnote='+e.data.footnote : '');
                        editor.insertContent( '[pipeline-chart '+ id + category + type + method + template + footnote +']');
                    }
                });
            },
        });
    });
})();