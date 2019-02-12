export default {
  handle (error) {
    let message = 'Unexpected Error'
    if (error.response.status == 404) {
      window.events.$emit('404')
      return
    }
    if (_.has(error, 'response.data.message')) {
      message = error.response.data.message
    }
    flash (message, {
      title: 'Error',
      className: 'error',
      linkTitle: 'Got it'
    })
  }
}
