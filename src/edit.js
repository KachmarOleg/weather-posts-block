import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { Fragment } from '@wordpress/element';

export default function Edit({ attributes, setAttributes }) {
    const { bigPostId, smallPost1Id, smallPost2Id } = attributes;

    const posts = useSelect((select) => {
        return select('core').getEntityRecords('postType', 'post', {
            per_page: 100,
            status: 'publish',
            orderby: 'title',
            order: 'asc'
        });
    }, []);

    const options = [
        { value: 0, label: '— Select post —' },
        ...(posts?.map(post => ({
            value: post.id,
            label: post.title.rendered
        })) || [{ value: 0, label: 'Loading...' }])
    ];

    return (
        <Fragment>
            <InspectorControls>
                <PanelBody title="Select posts">
                    <SelectControl
                        label="Big Post"
                        value={bigPostId}
                        options={options}
                        onChange={(value) =>
                            setAttributes({ bigPostId: parseInt(value) })
                        }
                    />

                    <SelectControl
                        label="Small post 1"
                        value={smallPost1Id}
                        options={options}
                        onChange={(value) =>
                            setAttributes({ smallPost1Id: parseInt(value) })
                        }
                    />

                    <SelectControl
                        label="Small post 2"
                        value={smallPost2Id}
                        options={options}
                        onChange={(value) =>
                            setAttributes({ smallPost2Id: parseInt(value) })
                        }
                    />
                </PanelBody>
            </InspectorControls>

            <div className="weather-posts-preview">
                <h3>Weather Posts Block</h3>
                <p>Big Post ID: {bigPostId || 'not selected'}</p>
                <p>Small Post 1 ID: {smallPost1Id || 'not selected'}</p>
                <p>Small Post 2 ID: {smallPost2Id || 'not selected'}</p>
            </div>
        </Fragment>
    );
}