import MessageFormatFormatter from './MessageFormatFormatter'

export default ({ app }) => {
  app.i18n.formatter = new MessageFormatFormatter(app.i18n.locale)
}
