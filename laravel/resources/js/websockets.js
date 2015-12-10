var socket = require('socket.io-client')('http://voldb.local:6001');
var $ = require('wetfish-basic');

$(document).ready(function()
{
    var event = $('.event').data('id');
    
    socket.on('connect', function()
    {
        console.log("Websocket connected!");
    });

    socket.on('event-'+event+':event-changed', function(data)
    {
        console.log("Event changed!", data);
    });

    socket.on('event-'+event+':slot-changed', function(data)
    {
        var slot = $('.slot[data-id="'+data.slot.id+'"]');

        if(data.change.status == 'taken')
        {
            slot.addClass('taken');
            slot.attr('href', '/slot/' + data.slot.id + '/release');
            slot.text(data.change.name);
        }
        else
        {
            slot.removeClass('taken');
            slot.attr('href', '/slot/' + data.slot.id + '/take');
            slot.text('');
        }
    });
});
