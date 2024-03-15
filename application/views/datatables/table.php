<style>
    .DTE_Field_Type_upload { display: none !important; }
    .btn-choose-file { cursor: pointer; }

    <?= $object->table_id ?> {
        border-bottom: 1px solid #ddd;
    }
    <?= $object->table_id ?> th:nth-child(1) {

        width: 40px !important;
        min-width: 40px !important;
    }

    <?= $object->table_id ?> td:nth-child(1) {
        text-align: center;
        white-space: nowrap;
    }

    .dataTables_scroll {overflow:auto}
    
    table.dataTable.display tbody>tr:hover,
    table.dataTable.display tbody>tr:hover>.sorting_1,
    table.dataTable.display tbody>tr:hover>.sorting_2,
    table.dataTable.display tbody>tr:hover>.sorting_3,
    table.dataTable.display tbody>tr:hover>.sorting_4,
    table.dataTable.display tbody>tr.selected>.sorting_2, 
    table.dataTable.display tbody>tr.selected>.sorting_1, 
    table.dataTable.display tbody>tr.selected>.sorting_3, 
    table.dataTable.display tbody>tr.selected>.sorting_4, 
    table.dataTable.display tr.selected
    {
        background-color: #eff3fd !important;
    }
    
    div.dataTables_wrapper div.dataTables_processing {
        z-index: 99;
    }
    
    .dataTables_wrapper .dataTables_processing {
        background: none !important;
        background-color: transparent !important;
        border-color:transparent !important;
    }
    .dataTables_scrollHeadInner {
        width: auto !important;
        overflow: hidden;
    }
</style>

<script>
    $('#tab a[data-toggle="tab"]').on('shown.bs.tab', function (e) {  
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });
    $(document).ready(function () {

        //Data table Editor Fields
        <?php if ( isset( $object->editor_fields ) ): ?>
            <?php foreach($object->editor_fields as $field): ?>
                var obj = {};
                <?php foreach((array)$field->get_fields() as $key => $value): ?>
                    //Checking if there is customize date  
                    <?php if($key == 'data_type' && $value == 'date'): ?>
                        (function ($, DataTable) {

                        if ( ! DataTable.ext.editorFields ) {
                            DataTable.ext.editorFields = {};
                        }

                        var Editor = DataTable.Editor;

                        DataTable.ext.editorFields.<?=$field->get_fields()->type;?> = {
                            create: function ( conf ) {
                                var that = this;
                                conf._enabled = true;
                                conf._input = $(
                                    '<div class="input-group date">'+
                                        '<input type="text" id="'+Editor.safeId( conf.id )+'"  class="form-control" style="border-radius: 0px !important;" />'+
                                        '<span class="input-group-addon">'+
                                            '<span class="glyphicon glyphicon-calendar"></span>'+
                                        '</span>' +
                                    '</div>'
                                );
                                return conf._input;
                            },

                            get: function ( conf ) {
                                return $('#' + conf.id).val();
                            },

                            set: function ( conf, val ) {
                                $(conf._input[0]).find( "input[id='"+conf.id+"']" ).val( val )
                            }
                        };


                    })(jQuery, jQuery.fn.dataTable);
                        
                        
                    <?php endif; ?>
            
            
                    <?php if($key == 'data_type' && $value == 'group_select'): ?>
                        
                        
                        (function ($, DataTable) {

                        if ( ! DataTable.ext.editorFields ) {
                            DataTable.ext.editorFields = {};
                        }

                        var Editor = DataTable.Editor;

                        DataTable.ext.editorFields.<?=$field->get_fields()->type;?> = {
                            create: function ( conf ) {
                                var that = this;
                                conf._enabled = true;
                                
                                $select_html = '<select id="'+Editor.safeId( conf.id )+'" class="form-control">';
                                
                                <?php foreach($field->get_fields()->options as $option_key => $option_value): ?>
                                    
                                    <?php if(trim($option_key) == ''): ?>
                                        <?php foreach($option_value as $select_data): ?>
                                        $select_html += '<option value="<?=$select_data["value"];?>"><?=$select_data["label"];?></option>';
                                        <?php endforeach; ?>
                                            <?php continue;?>
                                    <?php endif; ?>
                                    
                                $select_html += '<optgroup label="<?=$option_key; ?>">';
                                <?php foreach($option_value as $select_data): ?>                                    
                                    $select_html += '<option value="<?=$select_data['value'];?>"><?=$select_data['label'];?></option>';                                    
                                <?php endforeach;?>
                                
                                $select_html += '</optgroup>';                                
                                <?php endforeach; ?>
                                $select_html += '</select>';
                                
                                conf._input = $($select_html);
                                return conf._input;
                            },

                            get: function ( conf ) {
                                return $('#' + conf.id).val();
                            },

                            set: function ( conf, val ) {
                                
                                if ( $(conf._input[0]).find('option:contains('+val+')').length > 0)
                                {
                                    val = $(conf._input[0]).find('option:contains('+val+')').val();
                                    $(conf._input[0]).val(val);
                                }
                                else
                                {
                                    $(conf._input[0]).val(val)
                                }
                            }
                        };


                    })(jQuery, jQuery.fn.dataTable);
                        
                        
                    <?php endif; ?>
            
            
                    // File type
                    <?php if($key == 'type' && $value == 'file'): ?>
                        
                        
                        (function ($, DataTable) {

                        if ( ! DataTable.ext.editorFields ) {
                            DataTable.ext.editorFields = {};
                        }

                        var Editor = DataTable.Editor;

                        DataTable.ext.editorFields.<?=$field->get_fields()->type;?> = {
                            create: function ( conf ) {
                                var that = this;
                                conf._enabled = true;
                                
                                $html = '<div class="form-group input-group" style="margin:0">'
                                $html += '<input type="text" id="'+Editor.safeId( conf.id )+'" value="" placeholder="No file selected" class="required form-control" />'
                                $html += '<span class="input-group-addon btn-choose-file">'
                                $html += '<i class="fa fa-folder-open"></i>';
                                $html += '</span>';
                                $html += '</div>';
                                
                                conf._input = $($html);
                                return conf._input;
                            },

                            get: function ( conf ) {
                                return $('#' + conf.id).val();
                            },

                            set: function ( conf, val ) {
                                $(conf._input[0]).find( "input[id='"+conf.id+"']" ).val( val )
                            }
                        };


                    })(jQuery, jQuery.fn.dataTable);
                        
                        
                    <?php endif; ?>
                    
                    
                    // Select Icon Image
                    <?php if($key == 'type' && $value == 'select_icon_image'): ?>
                    
                        (function ($, DataTable) {

                            if ( ! DataTable.ext.editorFields ) {
                                DataTable.ext.editorFields = {};
                            }

                            var Editor = DataTable.Editor;

                            DataTable.ext.editorFields.select_icon_image = {
                                create: function ( conf ) {
                                    var that = this;
                                    conf._enabled = true;
                                    conf._input = $(
                                        '<div class="input-group" onClick="selectFile(\'DTE_Field_icon_image\')">'+
                                            '<input type="text" class="form-control" value="" id="'+Editor.safeId( conf.id )+'" />'+
                                            '<span class="input-group-addon btn-primary" id="basic-addon2">Select...</span>' +
                                        '</div>'
                                    );
                                    return conf._input;
                                },

                                get: function ( conf ) {
                                    return $('#' + conf.id).val();
                                },

                                set: function ( conf, val ) {
                                    $(conf._input[0]).find( "input[id='"+conf.id+"']" ).val( val )
                                }
                            };
                        })(jQuery, jQuery.fn.dataTable);
                    
                    <?php endif; ?>
                    // Select Icon Image -->
                    
                    // Select Icon Image -->
                    <?php if($key == 'type' && $value == 'summernote'): ?>
                    
                        (function ($, DataTable) {

                            if ( ! DataTable.ext.editorFields ) {
                                DataTable.ext.editorFields = {};
                            }

                            var Editor = DataTable.Editor;

                            DataTable.ext.editorFields.summernote = {
                                create: function ( conf ) {
                                    var that = this;
                                    conf._enabled = true;
                                    conf._input = $('<textarea class="form-control" id="'+Editor.safeId( conf.id )+'"></textarea>');
                                    return conf._input;
                                },

                                get: function ( conf ) {
                                    return $('#' + conf.id).val();
                                },

                                set: function ( conf, val ) {}
                            };

                        })(jQuery, jQuery.fn.dataTable);
                    
                    <?php endif; ?>
                    // Select Icon Image
                    
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        
        
    });
</script>

<?php $has_edit = isset($object->has_edit_dblclick) ? $object->has_edit_dblclick : false; ?>
<script>
    var documentSectionTable;

(function ($) {

    //'use strict';

    var myEditor;
    

    $(document).ready(function () {
        $(document).on("click", ".btn-choose-file", function(event){
            event.stopImmediatePropagation();
            $(".editor_upload").find("input").trigger("click");
        });
        
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });
        
        var server_params = {};
        <?php if( isset( $object->server_params["table_editor"] ) ): ?>
            <?php foreach($object->server_params["table_editor"] as $key => $param): ?>
                server_params['<?=$key?>'] = '<?=$param; ?>';
            <?php endforeach; ?>
        <?php endif; ?>
        
        var data_fields = new Array();
        <?php if ( isset( $object->editor_fields ) ): ?>
            <?php foreach($object->editor_fields as $field): ?>
                var obj = {};
                <?php foreach((array)$field->get_fields() as $key => $value): ?>
                    <?php $key = ($key == 'data_column') ? 'name' : $key?>
                    <?php $key = ($key == 'default') ? 'def' : $key?>

                    <?php if($key == 'type' && $value == 'upload'): ?>
                        obj.display = <?=$object->callbacks["uploadComplete"]; ?>
                    <?php endif; ?>

                    <?php if($key == 'options' && ((!isset($field->get_fields()->data_type)) || (isset($field->get_fields()->data_type) && $field->get_fields()->data_type != 'group_select')) ): ?>
                        obj['<?=$key?>'] = new Array();
                        <?php foreach($value as $option): ?>
                            var obj_options = {};
                            obj_options['label'] = '<?=$option['label']?>';
                            obj_options['value'] = '<?=$option['value']?>';
                            obj['<?=$key?>'].push( obj_options );
                        <?php endforeach;?>
                    <?php else: ?>
                        <?php if (is_bool($value)): ?>
                            obj['<?=$key?>'] = <?=($value)?'true':'false'?>;
                        <?php else:?>
                            obj['<?=$key?>'] = '<?= is_array($value) ? json_encode($value) : $value; ?>';
                        <?php endif;?>                    
                    <?php endif; ?>
                <?php endforeach;?>                

                data_fields.push(obj);

            <?php endforeach;?>
        <?php endif; ?>
        
        myEditor = new $.fn.dataTable.Editor({
            <?php if(isset($object->template)): ?>
                    template: '<?=$object->template?>',
            <?php endif;?>
                
            formOptions: {
                main: {
                    onEsc: false,
                    onBackground:  false,
                }
            },
                
            ajax: {
                url : '<?=$object->ajax_url;?>',
                type : 'POST',
                data : server_params
            },
            table: '<?=$object->table_id;?>',
            fields: data_fields,
            i18n: {
                create: {
                    title:  "<?=$object->create_title;?>"
                },
                edit: {
                    title:  "<?=$object->edit_title;?>"
                }
            }
        });
        
        <?php if( isset( $object->callbacks["displayOrder"] ) ): ?>            
            myEditor.on( 'open displayOrder', function ( e, mode, action) {
                <?=$object->callbacks["displayOrder"]?>(e, mode, action, this);
            });            
        <?php endif;?>
        
        <?php if( isset( $object->callbacks["postSubmit"] ) ): ?>
            myEditor.on( 'postSubmit', function ( e, json, data, action, xhr ) {
                return <?=$object->callbacks["postSubmit"]; ?>(e, json, data, action, xhr, this);
            });
        <?php endif; ?>
        
        <?php if( isset( $object->callbacks["preSubmit"] ) ): ?>
            myEditor.on( 'preSubmit', function ( e, o, action ) {
                return <?=$object->callbacks["preSubmit"]; ?>(e,o,action, this);
            });
        <?php endif; ?>

        <?php if( isset( $object->callbacks["preOpen"] ) ): ?>
        myEditor.on('preOpen', function(a, b, action) {
            return <?=$object->callbacks["preOpen"]; ?>(a,b,action, this);
        });
        <?php endif; ?>

        myEditor.on('open', function(a, b, action) {
            <?php if( isset( $object->callbacks["open"] ) ): ?>
                <?=$object->callbacks["open"]; ?>(a,b,action, this);
                <?php if ( isset( $object->editor_fields ) ): ?>
                    <?php foreach($object->editor_fields as $field): ?>
                        var obj = {};
                        <?php foreach((array)$field->get_fields() as $key => $value): ?>

                            <?php if($key == 'data_type' && $value == 'date'): ?>
                
                            var $datepicker = $('#DTE_Field_<?php echo $field->get_fields()->data_column;?>');
                            $datepicker.datepicker({ dateFormat: 'mm/dd/yy', autoclose: true });
                            
                            if ( typeof a.target.s.editData !== 'undefined' )
                            {
                                var formatDate = a.target.s.editData.<?php echo $field->get_fields()->data_column;?>[Object.keys( a.target.s.editData.<?php echo $field->get_fields()->data_column;?> )[0]];
                                if(formatDate != "0000-00-00" && formatDate != '' ){
                                    $datepicker.datepicker('setDate', new Date(formatDate));
                                }
                            }
                                
                            <?php endif; ?>
                                
                                
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>
            
            $("#closeEditor").remove();
            $(".DTE_Form_Buttons").prepend('<button id="closeEditor" class="btn" tabindex="1">Cancel</button>');
            $("#closeEditor").click(function(){myEditor.close()});

            $(".DTE_Form_Buttons").find(":contains('Delete')").removeClass("btn-primary");
            $(".DTE_Form_Buttons").find(":contains('Delete')").addClass("btn-danger");
        });

        
        <?php if( isset( $object->callbacks["close"] ) ): ?>
            myEditor.on('close', function(a, b, action) {
                <?=$object->callbacks["close"]; ?>(a,b,action,this);
            });
        <?php endif; ?>

        var buttons = new Array();        
        <?php if( isset( $object->table_buttons ) ): ?>
            <?php foreach($object->table_buttons as $dt_button): ?>
                var button_object = {};
                <?php $button = $dt_button->get_buttons(); ?>
                button_object.extend = '<?=$button->type?>';
                button_object.editor = myEditor;
                
                <?php if ( ($button->type == 'edit') ): ?>
                    <?php $has_edit = true; ?>
                <?php endif; ?>

                <?php if( isset($button->text) ): ?>
                    button_object.text = '<?=$button->text; ?>';
                <?php endif; ?>

                <?php if( isset($button->remove_message_callback) ): ?>
                    button_object.formMessage = <?=$button->remove_message_callback; ?>;
                <?php endif;?>

                <?php if( isset($button->action_callback) ): ?>
                    button_object.action = <?=$button->action_callback; ?>;
                <?php endif;?>


                buttons.push(button_object);
            <?php endforeach; ?>
        <?php endif; ?>
            
        var data_columns = new Array();
        <?php if( isset( $object->data_columns ) ): ?>
            <?php foreach($object->data_columns as $column): ?>
                data_columns.push({data: '<?=$column;?>'});
            <?php endforeach; ?>
        <?php endif; ?>
            
        var server_params = {};
        <?php if ( isset( $object->server_params["table_list"] ) ): ?>
            <?php foreach($object->server_params["table_list"] as $key => $param): ?>
                server_params['<?=$key?>'] = '<?=$param; ?>';
            <?php endforeach; ?>
        <?php endif; ?>
        
        var column_defs = new Array();
        <?php if( isset( $object->table_definitions ) ): ?>
            <?php foreach($object->table_definitions as $definitions): ?>
                var obj = {};
                <?php foreach($definitions as $key => $value): ?>
                    <?php if(is_bool ($value)  === true ) { ?>
                        obj['<?=$key?>'] = <?=$value ? 'true' : 'false' ?>;
                    <?php } else if(is_numeric ($value)  === true)  {?>
                        obj['<?=$key?>'] = <?=$value?>;
                    <?php } else {?>
                        obj['<?=$key?>'] = '<?= is_array($value) ? json_encode($value) : $value; ?>';
                    <?php } ?>
                <?php endforeach; ?>
                column_defs.push(obj);
            <?php endforeach; ?>
        <?php endif; ?>
            
        myTable = $('<?=$object->table_id; ?>').DataTable({
            autoWidth: false,
            processing : true,
            scrollX: <?= isset($object->scrollX) && $object->scrollX ? 'true'  : 'false' ?>,
            scrollCollapse: true,
            <?php if(isset($object->no_pagination) && $object->no_pagination): ?>
            paging:   false,
            <?php endif; ?>
            <?php if(isset($object->no_info) && $object->no_info): ?>
            info:   false,
            <?php endif; ?>
            oLanguage: {
                sSearch: "",
                sProcessing: "<img src='<?=base_url('images/ajax-loader-big.gif')?>'>",
                oPaginate: {
                    "sNext": '>',
                    "sLast": '>>',
                    "sFirst": '<<',
                    "sPrevious": '<'
                }
            },
            <?php if( isset( $object->fixedColumns ) && $object->fixedColumns ) : ?>
                fixedColumns:   {
                    leftColumns: <?= isset($object->leftColumns) ? $object->leftColumns : 1 ?>
                },
            <?php endif; ?>
            
            <?php if( !isset( $object->no_scroll ) ): ?>
            scrollY: "<?= isset($object->scrollY) ? $object->scrollY : '460px' ?>",
            <?php endif; ?>
            dom: 'Bfrtip',
            ajax: {
                url: '<?=$object->ajax_url;?>',
                type: 'POST',
                data: function( d ) {
                    $.each( server_params, function( key, value ) {                        
                        d[key] = value;
                    });
                    
                    $("#dt-extra-params input").each(function (key, value){
                        d[$(this).attr("name")] = $(this).val();
                    });

                    $("#dt-extra-params select").each(function (key, value){
                        d[$(this).attr("name")] = $(this).val();
                    });
                }
            },
            serverSide: <?=isset($object->server_side) && !$object->server_side ? 'false'  : 'true' ?>,
            searching: false,
            iDisplayLength: <?=isset($object->display_length) ? $object->display_length : 50; ?>,
            <?php if( isset( $object->callbacks["init_complete"] ) ): ?>
            initComplete: <?=$object->callbacks["init_complete"]; ?>,
            <?php endif; ?>
            columns: data_columns,
            <?php if( isset($object->order) ): ?>
            order: <?php echo json_encode($object->order);?>,
            <?php endif; ?>
            select: {
                style: '<?php echo isset($object->select_style) ? $object->select_style : 'single' ;?>',
            },
            lengthChange: false,
            buttons: buttons,
            <?php if(isset($object->callbacks["footerCallback"])): ?>
            footerCallback: function( row, data, start, end, display ){
                <?=$object->callbacks["footerCallback"];?>(row, data, start, end, display, this);
            },
            <?php endif; ?>
            columnDefs: column_defs
        });
        
        <?php if(isset($object->inline_edit_col) && is_array($object->inline_edit_col)): ?>            
            <?php $children = ''; ?>
            <?php foreach($object->inline_edit_col as $col): ?>
                <?php $children[] = 'tbody td:nth-child('.$col.')'; ?>
            <?php endforeach; ?>
                
            $('<?=$object->table_id;?>').on( 'click', '<?=implode(",", $children);?>', function (e) {
                myEditor.inline( myTable.cell(this).index(), {
                    onBlur: 'submit'
                });
            });
        <?php endif; ?>
            
        <?php if( isset( $object->callbacks["user_select"] ) ): ?>
            myTable.on( 'user-select', <?=$object->callbacks["user_select"]?>);
        <?php endif; ?>
        
        <?php if( $has_edit ): ?>
            <?php if( isset($object->edit_callback) ): ?>
                $('<?=$object->table_id;?> tbody').on( 'dblclick', 'tr', function () {
                    <?php echo $object->edit_callback; ?>
                });
            <?php else:?>
                $('<?=$object->table_id;?> tbody').on( 'dblclick', 'tr', function () {
                        myEditor.edit( this, '<?=$object->edit_title; ?>', 'Update');
                });
            <?php endif; ?>
        <?php endif; ?>

        <?php if( isset($object->has_delete_row) && $object->has_delete_row ): ?>            
            $('<?=$object->table_id;?> tbody ').on( 'click', '.dt_row_remove', function (e) {
                myEditor.remove( $(this).closest('tr'), 
                <?php if( isset($object->delete_row_callback_message) && $object->delete_row_callback_message ): ?>
                    <?=$object->delete_row_callback_message; ?>($(this).closest('tr')) 
                <?php else: ?>
                    {
                        title: 'Delete',
                        message: 'Are you sure you wish to remove this record?',
                        buttons: 'Delete'
                    }
                <?php endif; ?>
                );
            });
        <?php endif; ?>
    });    
}(jQuery));

$(function () {
    $('.dataTables_scrollBody').scroll(function(){
        $('.dataTables_scrollHeadInner').scrollLeft($(this).scrollLeft());
    });
});

<?php if($object->delete_row_callback_message == "dt_remove_row_callback") : ?>
    function dt_remove_row_callback(e){
        var name = $(e).find("td").eq(1).text();
        return {
            title: 'Delete',
            message: "Are you sure you wish to delete '" + name + "'?",
            buttons: 'Delete'
        };
    }
<?php endif; ?>

</script>