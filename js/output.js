!function (w, d) {
    w.output = function (content, targetId) {
        targetId || (targetId = 'output');
        var target = d.getElementById(targetId),
            p = d.createElement('p');
        p.innerHTML = content;
        target.appendChild(p);
    }
}(window, document);
