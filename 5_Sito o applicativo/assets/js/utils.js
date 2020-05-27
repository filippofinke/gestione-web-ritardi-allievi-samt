/**
 * Metodo utilizzato per aggiungere uno zero davanti ad un numero.
 *
 * @param {*} s Il numero al quale aggiungere il padding.
 */
const pad = (s) => {
  s = String(s);
  if (s.length == 1) {
    s = "0" + s;
  }
  return s;
};

/**
 * Metodo utilizzato per formattare una data.
 *
 * @param {*} d La data da formattare.
 */
const formatDate = (d) => {
  d = new Date(d);
  return pad(d.getDate()) + "." + pad(d.getMonth() + 1) + "." + d.getFullYear();
};
