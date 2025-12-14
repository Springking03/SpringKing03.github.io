function buildUrl(controller, action) {
    const hostname = window.location.hostname;
    const port = window.location.port;
    const protocol = window.location.protocol;
    let url = `${protocol}//${hostname}`;
    if (port) {
        url += `:${port}`;
    }
    url += `/Medicare/index.php?controller=${controller}&action=${action}`;
    return url;
}