import templateMessages from '~/core-admin/lang/pt-br'

const messages = {

  coreAdmin: {
    ...templateMessages
  },

  components: {
    selectInfiniteCategory: {
      searching: 'Buscando',
      searchingMore: 'Buscando mais',
      noOptions: 'Nenhum resultado encontrado',
      emptyOption: 'Nenhuma'
    },
  },

  config: {
    menu: {
      dashboard: 'Painel',
      categories: 'Categorias',
      products: 'Produtos',
    },
    userMenu: {
      profile: 'Perfil',
      logout: 'Sair'
    }
  },

  layouts: {
    error: {
      backpage: 'Voltar para a tela inicial',
      logout: 'Sair do sistema',
      errorMessage: {
        404: 'Não conseguimos encontrar a funcionalidade que você tentou acessar. Por favor, tente novamente ou entre em contato com a nossa equipe.',
        500: 'Ixi! Você descobriu um problema que a nossa equipe precisa investigar. Por favor, informe o nosso suporte sobre o ocorrido.',
      }
    }
  },

  pages: {
    index: {
      title: 'Gerenciamento de {name}',
      home: 'Início',
      add: 'Criar',
      filters: 'Filtros',
      filtersDescription: 'Utilize os filtros abaixo para encontrar o que procura com mais facilidade',
      nameOf: 'Nome {gender, select, male{do} female{da} other{}} {name}',
      showAll: 'Mostrar todos',
      onlyActives: 'Apenas ativos',
      onlyInactives: 'Apenas inativos',
      toggleActiveAlert: {
        title: 'Tem certeza?',
        html: 'A {singular_name} "{item_name}" será <strong>{status}</strong>.',
        activated: 'ativad{gender, select, male{o} female{a} other{}}',
        inactivated: 'inativad{gender, select, male{o} female{a} other{}}',
      },
      activeAll: {
        html: '{gender, select, male{Os} female{As} other{}} {plural_name} seleciona{gender, select, male{dos} female{das} other{}} serão <strong>ativa{gender, select, male{dos} female{das} other{}}</strong>.',
      },
      inactiveAll: {
        html: '{gender, select, male{Os} female{As} other{}} {plural_name} seleciona{gender, select, male{dos} female{das} other{}} serão <strong>inativa{gender, select, male{dos} female{das} other{}}</strong>.',
      },
      removeAll: {
        html: 'Tem certeza que deseja <strong>remover</strong> todos esses itens selecionados?'
      },
      removeAlert: {
        html: 'Tem certeza que deseja <strong>remover</strong> {gender, select, male{o} female{a} other{}} {singular_name} "{item_name}"?',
        confirmButtonText: 'Sim, pode remover',
        cancelButtonText: 'Não, não quero remover',
      },
      actions: {
        actions: 'Ações',
        active: 'Ativar',
        activeAll: 'Ativar todos',
        inactive: 'Inativar',
        inactiveAll: 'Inativar todos',
        edit: 'Editar',
        remove: 'Remover',
        removeAll: 'Remover todos',
        selectedItemsMessage: '{checkedItemsCount} itens selecionados',
        selectedItemsQuestion: 'O que fazer com os itens selecionados?',
        cleanSeletedItemsButton: 'Limpar seleção de itens'
      },
      table: {
        emptyText: 'Não há nenhum dado para ser exibido',
        emptyFilteredText: 'Nenhum registro foi encontrado',
      },
      pagination: {
        paginationMessage: 'Mostrando {per_page} do total de {total} {name}',
      }
    },
    form: {
      editing: 'Editando',
      creating: 'Criando',
      statusLabel: 'Criar {gender, select, male{o} female{a} other{}} {singular_name} como ativ{gender, select, male{o} female{a} other{}}?',
      statusWarning: 'Você pode alterar a situação {gender, select, male{do} female{da} other{}} {singular_name} a qualquer momento',
      successfullyCreated: 'Criad{gender, select, male{o} female{a} other{}} com sucesso! Você será redirecionado para a tela de edição.',
      successfullyUpdated: 'Atualizad{gender, select, male{o} female{a} other{}} com sucesso!',
      saveButton: 'Salvar',
      backButton: 'Voltar',
      cancelButton: 'Cancelar',
    },
    initial: {
      title: 'Treinamento de Laravel com Vue.js',
      start: 'Tudo começa na tela de',
      accessData: 'Dados de acesso são:',
      password: 'Senha'
    },
    login: {
      slogan: 'Transformando a realidade e criando possibilidades',
      password: 'Senha',
      accessButton: 'Acessar'
    },
    logout: {
      leaving: 'Saindo, aguarde'
    },
    dashboard: {
      title: 'Painel'
    },
    categories: {
      table: {
        activeColumn: 'Está ativa?',
      },
      toggleActiveAlert: {
        html: 'A {singular_name} "{item_name}" e suas associadas serão <strong>{status}</strong>.',
      }
    },
    user: {
      profile: {
        title: 'Perfil',
        description: 'Edite seus dados pessoais e a imagem do seu avatar',
        changeAvatarButton: 'Mudar Imagem',
        imageSuccessfullyUpdated: 'Imagem alterada com sucesso!'
      }
    }
  },

  plugins: {
    errorHandler: {
      errorMessages: {
        defaultGeneralErrorMessage: 'Ixi! Você descobriu um problema que a nossa equipe precisa investigar. Por favor, informe o nosso suporte sobre o ocorrido.',
        401: 'Você precisa estar logado para acessar esta funcionalidade.',
        403: 'Você não possui permissão para utilizar esta funcionalidade.',
        404: 'Não conseguimos encontrar a funcionalidade que você tentou acessar. Por favor, tente novamente ou entre em contato com a nossa equipe.',
        422: 'Erro na validação'
      }
    },
    filters: {
      yes: 'Sim',
      no: 'Não',
    },
    axios: {
      sessionExpiredAlert: 'Sessão expirada',
    },
    veeValidate: {
      gtZero: {
        messageWithField: 'O valor do campo {field_name} precisa ser maior do que zero',
        message: 'O valor deste campo precisa ser maior do que zero'
      },
      required: {
        messageWithField: 'O campo {field_name} é obrigatório',
        message: 'Este campo é obrigatório'
      },
      email: {
        messageWithField: 'O campo {field_name} precisa conter um e-mail válido',
        message: 'O e-mail informado é inválido'
      }
    }
  },

  repositories: {
    category: {
      plural: 'Categorias',
      singular: 'Categoria',
      nameColumn : 'Nome',
      parentCategoryColumn: 'Categoria Pai',
      activeColumn: 'Situação',
    },
    product: {
      plural: 'Produtos',
      singular: 'Produto',
      nameColumn : 'Nome',
      priceColumn : 'Preço',
      activeColumn: 'Situação',
    },
    user: {
      nameColumn: 'Nome',
    }
  }
}

export default messages
