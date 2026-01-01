<?php
function loop_item($url, $thumbnail, $formatted_date_string, $title, $description)
{
    return <<<EOT
        <a class="event flex flex-row gap-6 py-6 border-b border-gray-200 items-start hover:bg-gray-50 transition-colors duration-200" href="{$url}">
            <div class="event-image-wrapper w-32 h-32 flex-shrink-0 overflow-hidden rounded-full bg-gray-100">
                {$thumbnail}
            </div>
            
            <div class="event-info flex-grow">
                <div class="event-title">{$title}</div>
                <div class="event-date">
                    {$formatted_date_string}
                </div>
                <div class="event-description">
                    {$description}
                </div>
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
