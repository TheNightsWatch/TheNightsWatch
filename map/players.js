var TNWPlugin = function () {
    'use strict';
    // The Night's Watch Player Markers
    // A Heavily modified version of Overviewer's PlayerMarkers
    // specifically designed for MinezMap.com

    var $ = jQuery,
        JSONFile = 'https://minez-nightswatch.com/map/players',
        refreshTime = 2,
        avatarServer = 'https://minotar.net/helm/<playername>/<size>.png',
        players = {};

    /**
     * { name: { name: "", rank: "", server: "", location: {x: 0, y: 0, z: 0}, marker: obj } }
     */

    function loadPlayers() {
        /*
         * We'll use <script id="nightswatch-update"> for our JSONP, so that
         * we don't accidentally bog down the DOM.
         */
        var cacheBuster = (new Date()).getTime(),
            script = $('#nightswatch-update'),
            url = JSONFile + '?jsonp=TNWPluginInstance.updatePlayers&_time=' + cacheBuster;
        if (script.length) {
            script.remove();
        }
        $('body').append('<script src="' + url + '" id="nightswatch-update"></script>');
    }

    function getAvatarURL(name, size) {
        return avatarServer.replace('<playername>', name).replace('<size>', size);
    }

    this.updatePlayers = function (data) {
        var updated = {}, i, item, player, latlng, icon;
        var onclick = function(e) {
            mapUi.expandSidebar();
            mapUi.openUrl('https://minez-nightswatch.com/user/' + e.target.options.title);
        };
        for (i in data) {
            if (data.hasOwnProperty(i)) {
                /**
                 * @property string timestamp
                 * @property int id
                 * @property string msg
                 * @property string display
                 * @property string x
                 * @property string y
                 * @property string z
                 * @property string world
                 * @property string server
                 * @property string rank
                 * @type {*}
                 */
                item = data[i];
                if (players[item.display]) {
                    player = players[item.display];
                } else {
                    players[item.display] = {};
                    player = players[item.display];
                }
                player.name = item.display;
                player.rank = item.rank;
                player.server = item.server;
                player.location = {x: item.x, y: item.y, z: item.z };
                latlng = overviewer.util.fromWorldToLatLng(player.location.x, player.location.y, player.location.z, 0);
                latlng = [latlng.lat, latlng.lng];
                if (player.marker) {
                    player.marker.setLatLng(latlng);
                } else {
                    icon = L.icon({
                        iconUrl: getAvatarURL(player.name, 16),
                        iconRetinaUrl: getAvatarURL(player.name, 32),
                        iconSize: [16, 16]
                    });
                    player.marker = L.marker(latlng, {
                        icon: icon,
                        title: player.name,
                        riseOnHover: true
                    });
                    player.marker.addTo(overviewer.map);
                    player.marker.on('click', onclick);
                }
                updated[player.name] = true;
            }
        }
        for (i in players) {
            if (players.hasOwnProperty(i)) {
                if (!updated[players[i].name]) {
                    overviewer.map.removeLayer(players[i].marker);
                    delete players[i];
                }
            }
        }
    };

    window.setInterval(loadPlayers, 1000 * refreshTime);
};
window.TNWPluginInstance = new TNWPlugin();
