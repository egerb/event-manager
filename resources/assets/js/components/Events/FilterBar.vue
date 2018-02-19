<template>
    <div class="filter-bar">
      <form class="form-inline">
        <div class="form-group">
          <label>Поиск:</label>
          <input type="text" v-model="filterText" class="form-control" @keyup.enter="doFilter" placeholder="название">
          <button class="btn btn-primary" @click.prevent="doFilter">Искать</button>
          <button class="btn" @click.prevent="resetFilter">Сбросить</button>
        </div>
      </form>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        filterText: ''
      }
    },
    methods: {
      doFilter () {
        this.$events.fire('filter-set', this.filterText)
      },
      resetFilter () {
        this.filterText = ''
        this.$events.fire('filter-reset')
      }
    }
  }
</script>
<style>
.filter-bar {
  padding: 10px;
}
</style>
