import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';

( function( blocks, element, blockEditor ) {
    var el = element.createElement;
    var useBlockProps = blockEditor.useBlockProps;
 
    var blockStyle = {
        backgroundColor: '#900',
        color: '#fff',
        padding: '20px',
    };
 
    blocks.registerBlockType( 'gutenberg-examples/example-01-basic', {
        apiVersion: 2,
        title: 'Example: Basic',
        icon: 'universal-access-alt',
        category: 'design',
        example: {},
        edit: function() {
            var blockProps = useBlockProps( { style: blockStyle } );
            return el(
                'p',
                blockProps,
                'Hello World, step 1 (from the editor).'
            );
        },
        save: function() {
            var blockProps = useBlockProps.save( { style: blockStyle } );
            return el(
                'p',
                blockProps,
                'Hello World, step 1 (from the frontend).'
            );
        },
    } );
}(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor
) );