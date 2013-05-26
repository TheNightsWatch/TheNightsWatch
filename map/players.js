var TNWPlugin = function () {
    // The Night's Watch Player Markers
    // A Heavily modified version of Overviewer's PlayerMarkers
    // specifically designed for MinezMap.com

    var $ = jQuery;
    var JSONFile = 'https://minez-nightswatch.com/map/players';
    var refreshTime = 2;
    var avatarServer = 'https://minotar.net/helm/<playername>/<size>.png';
    /**
     * { name: { name: "", rank: "", server: "", location: {x: 0, y: 0, z: 0}, marker: obj } }
     */
    var players = {};

    function loadPlayers() {
        var cacheBuster = (new Date).getTime();
        /*
         * We'll use <script id="nightswatch-update"> for our JSONP, so that
         * we don't accidentally bog down the DOM.
         */
        var script = $('#nightswatch-update');
        if (script.length) {
            script.remove();
        }
        var url = JSONFile + '?jsonp=TNWPluginInstance.updatePlayers&_time=' + cacheBuster;
        $('body').append('<script src="' + url + '" id="nightswatch-update"></script>');
    }

    this.updatePlayers = function (data) {
        var updated = {};
        for (var i in data) {
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
            var item = data[i];
            var player;
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
            var latlng = overviewer.util.fromWorldToLatLng(player.location.x, player.location.y, player.location.z, 0);
            latlng = [latlng.lat, latlng.lng];
            if (player.marker) {
                player.marker.setLatLng(latlng);
            } else {
                var icon = L.icon({
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
            }
            updated[player.name] = true;
        }
        for (var i in players) {
            if (!updated[players[i].name]) {
                overviewer.map.removeLayer(players[i].marker);
                delete players[i];
            }
        }
    };

    function getAvatarURL(name, size) {
        return avatarServer.replace('<playername>', name).replace('<size>', size);
    }

    var timer = setInterval(loadPlayers, 1000 * refreshTime);
};
window.TNWPluginInstance = new TNWPlugin();
