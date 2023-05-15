<?php
function loop_item($url, $thumbnail, $formatted_date, $formatted_time, $formatted_time_end, $title, $location)
{
    return <<<EOT
        <a class="event" href="{$url}">
            {$thumbnail}
            <div class="event-info">
                <div class="event-date">{$formatted_date} at {$formatted_time} - {$formatted_time_end}</div>
                <div class="event-title">{$title}</div>
                <div class="event-location">{$location}</div>
            </div>
        </a>
    EOT;
}

function loop_wrapper_start()
{
    return '<div class="events">';
}

function loop_wrapper_end()
{
    return '</div>';
}
