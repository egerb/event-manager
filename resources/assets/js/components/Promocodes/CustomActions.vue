  <template>
    <div class="custom-actions">
      <!--<button class="btn btn-sm" @click="itemAction('view-item', rowData, rowIndex)"><i class="glyphicon glyphicon-zoom-in"></i></button>-->
      <!--<button class="btn btn-sm" @click="itemAction('edit-item', rowData, rowIndex)"><i class="glyphicon glyphicon-pencil"></i></button>-->
      <button class="btn btn-sm" @click="itemAction('delete-item', rowData, rowIndex)"><i class="glyphicon glyphicon-trash"></i></button>
    </div>
  </template>

  <script>
  export default {
    props: {
      rowData: {
        type: Object,
        required: true
      },
      rowIndex: {
        type: Number
      }
    },
    methods: {
      itemAction (action, data, index) {
          if (action == 'delete-item')
              this.$parent.$parent
                  .client.delete('promo/'+data.uid)
                  .then((response) => {
                      (response.data.state == 'success') ? this.$parent.$snotify.warning(response.data.message) : this.$parent.$snotify.error(response.data.message);
                      this.$parent.resetData()
                      this.$parent.reload()
                        console.log(response)
                  })
//        console.log('custom-actions: ' + action, data.name, index)
      }
    }
  }
  </script>

  <style>
    .custom-actions button.ui.button {
      padding: 8px 8px;
    }
    .custom-actions button.ui.button > i.icon {
      margin: auto !important;
    }
  </style>
