<?php
function loop_item($url, $thumbnail, $formatted_date, $formatted_time, $formatted_time_end, $title, $location)
{
    return <<<EOT
        <a class="event" href="{$url}">
            <div class="event-image-wrapper">{$thumbnail}</div>
            <div class="event-info">
                <div class="event-date">{$formatted_date} at {$formatted_time} - {$formatted_time_end}</div>
                <div class="event-title">{$title}</div>
                <div class="event-location">{$location}</div>
            </div>
        </a>
    EOT;
}

function loop_wrapper_start($value)
{
    return '<div class="hipsy-events-widget ' . $value . '">';
}

function loop_wrapper_end()
{
    return '</div>';
}
