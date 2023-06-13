<?php
add_filter(
    'rest_events_collection_params',
    function ($params) {
        $params['orderby']['enum'][] = 'hipsy_events_date';
        return $params;
    },
    10,
    1
);

add_filter(
    'rest_events_query',
    function ($args, $request) {
        $order_by = $request->get_param('orderby');
        if (isset($order_by) && 'hipsy_events_date' === $order_by) {
            $args['meta_key'] = $order_by;
            $args['orderby']  = 'meta_value'; // user 'meta_value_num' for numerical fields
            $args['order']    = 'ASC'; // ASC or DESC
        }
        return $args;
    },
    10,
    2
);
