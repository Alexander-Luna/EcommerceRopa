<script id="__bs_script__">
    let debug = true;
    //debug = false;
    if (debug) {
        try {
            (function() {
                try {
                    var script = document.createElement('script');
                    if ('async') {
                        script.async = true;
                    }
                    script.src = 'http://HOST:3000/browser-sync/browser-sync-client.js?v=3.0.2'.replace("HOST", location.hostname);
                    if (document.body) {
                        document.body.appendChild(script);
                    } else if (document.head) {
                        document.head.appendChild(script);
                    }
                } catch (e) {
                    console.error("Browsersync: could not append script tag", e);
                }
            })()
        } catch (error) {}
    }
</script>