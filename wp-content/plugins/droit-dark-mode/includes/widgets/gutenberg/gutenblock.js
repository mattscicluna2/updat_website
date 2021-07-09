"use strict";
( function( blocks, i18n, editor, element, components ) {

    var el = element.createElement, 
        TextControl = components.TextControl,
        InspectorControls = editor.InspectorControls; 
        var __ = wp.i18n.__;
        var SelectControl = wp.components.SelectControl;

    // register our block
    blocks.registerBlockType( 'drdt/darkmode', {
        title: 'Dark Mode',
        icon: 'feedback',
        category: 'common',
        keywords: [
            __( 'dark' ),
            __( 'light' ),
            __( 'wp dark' ),
        ],
       
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var styleId = props.attributes.styleId;
            if( ! styleId ) styleId = 0;

            //console.log(props);

            // style render
            var styleItems = [];
            _.each( drdt_dark.style, function( form, index ) {
                styleItems.push({ value: index, label : form })
            });

            var children = [];
            // render fields
            children.push( 
                el(SelectControl, {
                    label: __('Dark Style'),
                    value: attributes.styleId,
                    options: styleItems,
                    selected: attributes.styleId,
                    onChange: function(value) {
                        setAttributes({
                            styleId: value
                        });
                    }
                })
            );
             
            return [
                children
            ];
        },

        save: function( props ) {
            return null;
        }
        
    } );

} )(
    window.wp.blocks,
    window.wp.i18n,
    window.wp.editor,
    window.wp.element,
    window.wp.components
);