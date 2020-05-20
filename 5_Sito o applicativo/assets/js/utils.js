const pad = (s) => {
    s = String(s);
    if (s.length == 1) {
        s = "0" + s;
    }
    return s;
}

const formatDate = (d) => {
    d = new Date(d);
    return pad(d.getDate()) + "." + pad((d.getMonth() + 1)) + "." + d.getFullYear();
};