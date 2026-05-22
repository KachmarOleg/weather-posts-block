const { registerBlockType } = wp.blocks;
const { createElement, Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { SelectControl, PanelBody } = wp.components;
const { useSelect } = wp.data;

registerBlockType('custom/weather-posts-block', {
    title: 'Weather Posts',
    icon: 'smiley',
    category: 'widgets',

    attributes: {
        bigPostId: {
            type: 'number',
            default: 0
        },
        smallPost1Id: {
            type: 'number',
            default: 0
        },
        smallPost2Id: {
            type: 'number',
            default: 0
        }
    },

    edit: function (props) {
        const { attributes, setAttributes } = props;
        const { bigPostId, smallPost1Id, smallPost2Id } = attributes;

        const posts = useSelect((select) => {
            return select('core').getEntityRecords('postType', 'post', {
                per_page: 100,
                status: 'publish',
                orderby: 'title',
                order: 'asc'
            });
        }, []);

        let options = [{ value: 0, label: '— Select post —' }];

        if (posts) {
            posts.forEach(post => {
                options.push({
                    value: post.id,
                    label: post.title.rendered
                });
            });
        } else {
            options = [{ value: 0, label: 'Loading...' }];
        }

        return createElement(
            Fragment,
            null,
            createElement(
                InspectorControls,
                null,
                createElement(
                    PanelBody,
                    { title: 'Select posts' },
                    createElement(SelectControl, {
                        label: 'Big Post',
                        value: bigPostId,
                        options: options,
                        onChange: (value) => setAttributes({ bigPostId: parseInt(value) })
                    }),
                    createElement(SelectControl, {
                        label: 'Small post 1',
                        value: smallPost1Id,
                        options: options,
                        onChange: (value) => setAttributes({ smallPost1Id: parseInt(value) })
                    }),
                    createElement(SelectControl, {
                        label: 'Small post 2',
                        value: smallPost2Id,
                        options: options,
                        onChange: (value) => setAttributes({ smallPost2Id: parseInt(value) })
                    })
                )
            ),

            createElement(
                'div',
                {
                    style: {
                        padding: '20px',
                        border: '1px solid #ccc',
                        background: '#f9f9f9'
                    }
                },
                createElement('h3', null, 'Weather Posts Block'),
                createElement('p', null, `Big Post ID: ${bigPostId || 'not selected'}`),
                createElement('p', null, `Small Post 1 ID: ${smallPost1Id || 'not selected'}`),
                createElement('p', null, `Small Post 2 ID: ${smallPost2Id || 'not selected'}`)
            )
        );
    },

    save: function () {
        return null;
    }
});