module.exports = {
  root: true,
  env: {
    browser: true,
    node: true
  },
  parserOptions: {
    parser: '@babel/eslint-parser',
    requireConfigFile: false
  },
  extends: [
    '@nuxtjs',
    'plugin:nuxt/recommended',
    'prettier'
  ],
  plugins: [
  ],
  // add your custom rules here
  rules: {
    "camelcase": "off",
    "no-prototype-builtins": "off",
    "eqeqeq": "off",
    "vue/require-prop-types": "off",
    "vue/require-default-prop": "off",
    'no-console': 'off',
  }
}
