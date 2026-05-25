import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, SelectControl, ToggleControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { Fragment } from '@wordpress/element';

export default function Edit({ attributes, setAttributes }) {
    const {
        smallPost1Id, smallPost2Id,
        showLocation, showTemperature, showFeelsLike,
        showCondition, showHumidity, showPressure,
        showWindSpeed, showSunrise, showSunset,
    } = attributes;

    const blockProps = useBlockProps();

    const posts = useSelect( (select) => {
        return select('core').getEntityRecords('postType', 'post', {
            per_page: 100,
            status: 'publish',
            orderby: 'title',
            order: 'asc',
        });
    }, [] );

    const options = [
        { value: 0, label: '— Select post —' },
        ...(posts?.map( post => ({
            value: post.id,
            label: post.title.rendered,
        })) || [{ value: 0, label: 'Loading...' }]),
    ];

    return (
        <Fragment>
            <InspectorControls>
                <PanelBody title="Select Posts" initialOpen={true}>
                    <SelectControl
                        label="Small Post 1"
                        value={smallPost1Id}
                        options={options}
                        onChange={(value) => setAttributes({ smallPost1Id: parseInt(value) })}
                    />
                    <SelectControl
                        label="Small Post 2"
                        value={smallPost2Id}
                        options={options}
                        onChange={(value) => setAttributes({ smallPost2Id: parseInt(value) })}
                    />
                </PanelBody>

                <PanelBody title="Weather Fields" initialOpen={false}>
                    <ToggleControl label="Location name"        checked={showLocation}    onChange={(v) => setAttributes({ showLocation: v })}    />
                    <ToggleControl label="Temperature"          checked={showTemperature} onChange={(v) => setAttributes({ showTemperature: v })} />
                    <ToggleControl label="Feels-like"           checked={showFeelsLike}   onChange={(v) => setAttributes({ showFeelsLike: v })}   />
                    <ToggleControl label="Weather condition"    checked={showCondition}   onChange={(v) => setAttributes({ showCondition: v })}   />
                    <ToggleControl label="Humidity"             checked={showHumidity}    onChange={(v) => setAttributes({ showHumidity: v })}    />
                    <ToggleControl label="Pressure"             checked={showPressure}    onChange={(v) => setAttributes({ showPressure: v })}    />
                    <ToggleControl label="Wind speed"           checked={showWindSpeed}   onChange={(v) => setAttributes({ showWindSpeed: v })}   />
                    <ToggleControl label="Sunrise"              checked={showSunrise}     onChange={(v) => setAttributes({ showSunrise: v })}     />
                    <ToggleControl label="Sunset"               checked={showSunset}      onChange={(v) => setAttributes({ showSunset: v })}      />
                </PanelBody>
            </InspectorControls>

            <div {...blockProps}>
                <h3>Weather Posts Block</h3>
                <p>Small Post 1 ID: {smallPost1Id || 'not selected'}</p>
                <p>Small Post 2 ID: {smallPost2Id || 'not selected'}</p>
                <p><em>Weather snippet loads on frontend</em></p>
            </div>
        </Fragment>
    );
}