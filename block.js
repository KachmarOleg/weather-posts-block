const { registerBlockType } = wp.blocks;
const { createElement } = wp.element;

registerBlockType('custom/weather-posts-block', {
    title: 'Weather Posts',
    icon: 'smiley',
    category: 'widgets',

    edit: function () {
        return createElement(
            'div',
            {
                style: {
                    padding: '20px',
                    border: '1px solid #ccc',
                },
            },
            'Weather Posts Block Preview'
        );
    },

    save: function () {
        return null;
    },
});