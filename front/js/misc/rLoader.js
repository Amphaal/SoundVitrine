
class RLoader {

    constructor(rLoaderId, defaultPath) {
        
        this._rLoader = document.getElementById(rLoaderId);
        
        this._mustDisplayBackButton = false;
        this._previousResponseUrl = null;
        this._currentUrl = defaultPath;

        this._initialLoadPromise = _XMLHttpPromise("GET", this._currentUrl)
            .then(function(xmlr) {
                this._rLoader.innerHTML = xmlr.response;
                this._init();
            }.bind(this));
    }

    initialAnimation() {
        let firstAnim = this._rLoader.style.opacity === "";

        if(firstAnim) return new Promise(function(resolve) {

            removeNotification(".connect-side");
            
            document.querySelector("#wtnz-connect .connect-side").classList.add("anima");
            document.getElementById("bg").classList.add("show");
            let cc = document.getElementById("connectContainer");
    
            let waitAll = [
                waitTransitionEnd(cc, function() { 
                    cc.classList.add("anima");
                }),
                this._initialLoadPromise
            ];
            
            Promise.all(waitAll)
                .then(this._fadeIn.bind(this))
                .then(resolve);
    
        }.bind(this));
    
        /* dummy promise */
        return Promise.resolve(null);
    }

    _getButtons() {
        return this._rLoader.querySelectorAll("button[href]");
    }

    _getForm() {
        return this._rLoader.querySelector("form");
    }

    _fadeIn() {
        return waitTransitionEnd(this._rLoader, function() {
            this._rLoader.style.pointerEvents = "";
            this._rLoader.style.opacity = 1;
        }.bind(this));
    }

    _fadeOut() {
        return waitTransitionEnd(this._rLoader, function() {
            this._rLoader.style.pointerEvents = "none";
            this._rLoader.style.opacity = 0;
        }.bind(this));
    }

    _goXMLR(method, url, POSTParams, requestingBackButton) {

        let awaitAll = [
            _XMLHttpPromise(method, url, POSTParams), 
            this._fadeOut()
        ];
        
        return Promise.all(awaitAll).then(function(results) {
            
            let xmlr = results[0];
            let newRUrl = xmlr.responseURL;
            
            if(this._previousResponseUrl != newRUrl) {
                this._previousResponseUrl = this._currentUrl;
                this._currentUrl = newRUrl;
                this._mustDisplayBackButton = Boolean(requestingBackButton);
            }

            this._fillWithContent(xmlr.response);

        }.bind(this));

    };

    _injectBackButton() {
        let btn = document.createElement("button");
        btn.innerHTML = "<<";
        this._rLoader.appendChild(btn);

        btn.onclick = function(event) {
            debugger;
            event.preventDefault();
            this._goXMLR(
                "GET", 
                this._previousResponseUrl
            );
        }.bind(this);
    }

    _fillWithContent(content) {
        if(content) {
            this._rLoader.innerHTML = content;
            if(this._mustDisplayBackButton) this._injectBackButton();
            this._init();
        }

        this._fadeIn();

    }

    _init() {
    
        //buttons
        let aBtns = this._getButtons();
        if(aBtns.length) aBtns.forEach(function(e) {
            let url = e.getAttribute("href");
            e.onclick = function(event) {
                event.preventDefault();
                this._goXMLR(
                    "GET", 
                    url, 
                    null, 
                    !e.hasAttribute("no-back")
                );
            }.bind(this);
            e.removeAttribute("href");
        }.bind(this));
    
        //forms
        let aForm = this._getForm();
        if(aForm) aForm.onsubmit = function(event) {
            event.preventDefault();
            this._goXMLR(
                aForm.getAttribute("method"), 
                aForm.getAttribute("action"),
                new FormData(aForm)
            );
        }.bind(this);

        this._rLoader.setAttribute("loaded", true);
    }

}

