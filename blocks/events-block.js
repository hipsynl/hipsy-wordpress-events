(function (blocks, element, components, editor, apiFetch) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var useEffect = element.useEffect;
    var useState = element.useState;

    registerBlockType('plugin/events-block', {
        title: 'Hipsy Events list',
        icon: 'calendar',
        category: 'common',

        attributes: {
            numberOfPosts: {
                type: 'text',
                default: '5',
            },
            eventList: {
                type: 'array',
                default: [],
            },
        },
        
        edit: function (props) {
            console.log("edit function:", props.attributes);
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            function onChangeNumberOfPosts(value) {
                if(value < 1) {
                    value = 1;
                }
                fetchItems(value);
            }

            function fetchItems(numberOfPosts) {
                const fields = ['title', 'featured_media', 'metadata.hipsy_events_date', 'metadata.hipsy_events_date_end'].join(',');

                apiFetch({ path: `/wp/v2/events?per_page=${numberOfPosts}&_fields=${fields}&order_by=hipsy_events_date` })
                    .then(function (events) {
                        var eventPromises = events.map(function (event) {
                            // Fetch the featured media for each event
                            return apiFetch({ path: '/wp/v2/media/' + event.featured_media })
                                .then(function (media) {
                                    // Get the medium-sized image URL from the media response
                                    var imageUrl = media.media_details.sizes.medium.source_url;
        
                                    // Return the event data with the image URL
                                    return {
                                        title: event.title.rendered,
                                        date: formatDate(event.metadata.hipsy_events_date),
                                        img: imageUrl,
                                    };
                                });
                        });
        
                        // Resolve all the event promises
                        return Promise.all(eventPromises);
                    })
                    .then(function (eventList) {
                        console.log("numberOfPosts", numberOfPosts);
                        // Update the eventList attribute with the fetched events
                        setAttributes({ numberOfPosts: numberOfPosts, eventList: eventList });
                        
                    })
                    .catch(function (error) {
                        console.error('Error fetching events:', error);
                    });
            }
            // Initial fetch of events
            useEffect(function () {
                fetchItems(attributes.numberOfPosts);
            }, []);

            return el(
                'div',
                null,
                el(InspectorControls, null, el(PanelBody, {
                    title: 'Settings',
                    initialOpen: true,
                }, el(TextControl, {
                    label: 'Number of Posts',
                    value: attributes.numberOfPosts,
                    type: 'number',
                    onChange: onChangeNumberOfPosts,
                }))),
                el(
                    'ul',
                    {style: {padding: '0px'}},
                    attributes.eventList.map(function (event, index) {
                        return el(
                            'li',
                            { key: index, style: { display: 'flex', alignItems: 'center', marginBottom: "5px" } },
                            el('img', { src: event.img, style: { borderRadius: "6px", flexShrink: '0', marginRight: '8px', width: '100px', height: '50px' } }),
                            el('div',{style: {overflow: "hidden", flexShrink: '1', display: 'flex', flexDirection: 'column'}}, 
                                el('span', null, event.date),
                                el('span', {class: "has-medium-font-size", style: {overflow: "hidden", textOverflow: "ellipsis", whiteSpace: "nowrap"}}, event.title)
                            )
                        );
                    })
                ),
                el(
                    'p',
                    { class: 'has-text-align-center' },
                    'Events automatically synced with Hipsy.',
                    el('br', null),
                    'Also an event organiser? ',
                    el('a', { href: 'https://hipsy.nl' }, 'Download the free plugin here')
                  )
            );
        },

        save: function () {
            return null;
        },
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.components,
    window.wp.editor,
    window.wp.apiFetch,
);



function formatDate(dateString) {
    const options = { month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' };
    const date = new Date(dateString);
    const formattedDate = date.toLocaleDateString('en-US', options);
    
    return formattedDate;
}
   
function getNumberSuffix(day) {
    if (day === 1 || day === 21 || day === 31) {
        return 'st';
    } else if (day === 2 || day === 22) {
        return 'nd';
    } else if (day === 3 || day === 23) {
        return 'rd';
    } else {
        return 'th';
    }
}