///
///ENTRYPOINT
///

function displayApp() {
    return new Promise(function(resolve){
        
        //force loader bar to max
        _updateLoaderBar(100);

        //end loading, start animations...
        hideLoader().then(showApp)
                    .then(removeLoader)
                    .then(resolve);
    });
}

///
///HELPERS UI
///

//hide loader bar
function hideLoader() {
    return new Promise(function(resolve, reject) {
        //fade-in
        let loader = document.getElementById("loader");
        loader.classList.remove("fadeIn");
        loader.classList.add("fadeOut");

        //permit underlying interactions
        document.getElementById("loader-container").style.pointerEvents = "none";

        return resolve();
    });
}

//remove loader from layout
function removeLoader() {
    return new Promise(function(resolve){
        let target = document.getElementById("loader-container");
        target.parentElement.removeChild(target);
        return resolve();
    });
}

//show content
function showApp() {
    return new Promise(function(resolve) {
        let content = document.getElementById("wtnz-library");

        return waitAnimationEnd(content, function() {
            content.classList.add("animated");
            content.classList.add("fadeIn");
        }).then(resolve);
    });
}

//update loader bar
function updateProgress(evt){
    var total = evt.srcElement.getResponseHeader("x-original-content-length") || evt.total; //bypass chrome compression proxy
    if (total) {
        let percentComplete = (evt.loaded / total) * 100;  
        _updateLoaderBar(percentComplete);
    } 
}

function _updateLoaderBar(newPercent) {
    newPercent = newPercent - 100;
    document.getElementById("loader-bar").style.transform = "translateX(" + newPercent + "%)";
}