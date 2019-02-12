export default {
  start (el) {
    el = el !== undefined ? document.querySelector(el) : document.body
    if (el) {
      el.classList.add('preloader')
    }
  },
  stop (el) {
    el =
      el !== undefined
        ? document.querySelector(el)
        : document.querySelector('.preloader')
    if (el) {
      el.classList.remove('preloader')
    }
  }
}
