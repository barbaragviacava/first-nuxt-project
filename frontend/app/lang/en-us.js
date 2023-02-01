import templateMessages from '~/core-admin/lang/en-us'

const messages = {

  coreAdmin: {
    ...templateMessages
  },

  components: {
    selectInfiniteCategory: {
      searching: 'Searching',
      searchingMore: 'Searching more',
      noOptions: 'No results found',
      emptyOption: 'None'
    },
  },

  config: {
    menu: {
      dashboard: 'Dashboard',
      categories: 'Categories',
      products: 'Products',
    },
    userMenu: {
      profile: 'Profile',
      logout: 'Logout'
    }
  },

  layouts: {
    error: {
      backpage: 'Back to main page',
      logout: 'Logout',
      errorMessage: {
        404: 'We couldn\'t find the feature you were trying to access. Please try again or contact our team.',
        500: 'Jezz! You\'ve discovered an issue that our team needs to investigate. Please let our support know what happened.',
      }
    }
  },

  pages: {
    index: {
      title: '{name} managing',
      home: 'Home',
      add: 'Add',
      filters: 'Filters',
      filtersDescription: 'Use these filters below to find what you\'re looking more easily',
      nameOf: '{name} Name',
      showAll: 'Show all',
      onlyActives: 'Only actives',
      onlyInactives: 'Only inactives',
      toggleActiveAlert: {
        title: 'Are you sure?',
        html: 'The {singular_name} "{item_name}" will be <strong>{status}</strong>.',
        activated: 'activated',
        inactivated: 'inactivated',
      },
      activeAll: {
        html: 'The selected {plural_name} will be <strong>activated</strong>.',
      },
      inactiveAll: {
        html: 'The selected {plural_name} will be <strong>inactivated</strong>.',
      },
      removeAll: {
        html: 'Are you sure you want to <strong>remove</strong> all these selected items?'
      },
      removeAlert: {
        html: 'Are you sure you want to <strong>remove</strong> {singular_name} "{item_name}"?',
        confirmButtonText: 'Yes, I have',
        cancelButtonText: 'No, I don\'t want to remove',
      },
      actions: {
        actions: 'Actions',
        active: 'Active',
        activeAll: 'Active all',
        inactive: 'Inactive',
        inactiveAll: 'Inactive all',
        edit: 'Edit',
        remove: 'Remove',
        removeAll: 'Remove all',
        selectedItemsMessage: '{checkedItemsCount} selected items',
        selectedItemsQuestion: 'What to do with the selected items?',
        cleanSeletedItemsButton: 'Clear selection'
      },
      table: {
        emptyText: 'There are no records matching your request',
        emptyFilteredText: 'There are no records matching your request',
      },
      pagination: {
        paginationMessage: 'Showing {per_page} of total {total} {name}',
      }
    },
    form: {
      editing: 'Editing',
      creating: 'Creating',
      statusLabel: 'Create {singular_name} as active?',
      statusWarning: 'You can change the status of {singular_name} at any time.',
      successfullyCreated: 'Successfully created! You will be redirected to the edit screen.',
      successfullyUpdated: 'Successfully updated!',
      saveButton: 'Save',
      backButton: 'Back',
      cancelButton: 'Cancel',
    },
    initial: {
      title: 'Laravel with Vue.js Training',
      start: 'Everything starts with ',
      accessData: 'Access account:',
      password: 'Password'
    },
    login: {
      password: 'Password',
      accessButton: 'Login'
    },
    logout: {
      leaving: 'Leaving, wait a moment'
    },
    dashboard: {
      title: 'Dashboard'
    },
    categories: {
      table: {
        activeColumn: 'Is Active?',
      },
      toggleActiveAlert: {
        html: 'The {singular_name} "{item_name}" and its associates will be <strong>{status}</strong>.',
      }
    },
    user: {
      profile: {
        title: 'Profile',
        description: 'Edit your personal information and your avatar image',
        changeAvatarButton: 'Change Image',
        imageSuccessfullyUpdated: 'Image successfully changed!'
      }
    }
  },

  plugins: {
    errorHandler: {
      errorMessages: {
        defaultGeneralErrorMessage: 'Jezz! You\'ve discovered an issue that our team needs to investigate. Please let our support know what happened.',
        401: 'You need to be logged in to access this feature.',
        403: 'You do not have permission to use this feature.',
        404: 'We couldn\'t find the feature you were trying to access. Please try again or contact our team.',
        422: 'Validation error'
      }
    },
    filters: {
      yes: 'Yes',
      no: 'No',
    },
    axios: {
      sessionExpiredAlert: 'Session expired',
    },
    veeValidate: {
      gtZero: {
        messageWithField: 'Field value {field_name} must be greater than zero',
        message: 'The value of this field must be greater than zero.'
      },
      required: {
        messageWithField: 'Field {field_name} is mandatory',
        message: 'This field is required'
      },
      email: {
        messageWithField: 'Field {field_name} must contain a valid email',
        message: 'E-mail is invalid'
      }
    }
  },

  repositories: {
    category: {
      plural: 'Categories',
      singular: 'Category',
      nameColumn : 'Name',
      parentCategoryColumn: 'Parent Category',
      activeColumn: 'Status',
    },
    product: {
      plural: 'Products',
      singular: 'Product',
      nameColumn : 'Name',
      priceColumn : 'Price',
      activeColumn : 'Status',
    },
    user: {
      nameColumn: 'Name',
    }
  }
}

export default messages
