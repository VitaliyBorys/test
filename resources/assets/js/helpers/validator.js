/* eslint-disable no-undef */
import errorHandler from './errorHandler'
class Validatator {
  do (error) {
    let response = error.response
    this.undo()
    if (_.has(response, 'data.errors')) {
      let errors = response.data.errors
      if (errors) {
        for (let key in errors) {
          let field = document.querySelector('[name="' + key + '"]')
          if (field) {
            field.parentNode.classList.add('input--error')
            var span = document.createElement('span')
            span.classList.add('input__error-message')
            span.innerHTML = errors[key][0]
            field.parentNode.appendChild(span)
          }
        }
      }
      return
    }
    errorHandler.handle(error)
  }
  undo () {
    let messages = document.querySelectorAll('span.input__error-message')
    messages.forEach(message => {
      message.remove()
    })

    let elements = document.querySelectorAll('.input--error')
    elements.forEach(element => {
      element.classList.remove('input--error')
    })
  }
}

export default new Validatator()
