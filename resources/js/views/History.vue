<template>
  <div class="container mt-3">
    <h1 class="h2">История активностей</h1>
      <div class="row m-2">
        <div class="col-2">
          <p>Дата начала</p>
          <date-picker v-model="startDate" :disabled-date="notAfterEndDate"></date-picker>
        </div>
        <div class="col-2 offset-1">
          <p>Дата конца</p>
          <date-picker v-model="endDate" :disabled-date="notAfterToday"></date-picker>
        </div>
        <div class="col-2 offset-1 d-flex align-items-end">
          <button @click="fetchHistory" class="btn btn-primary">
            <span v-if="isDayActivitiesLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Отправить
          </button>
        </div>
      </div> 

      <div v-if="activities.length > 0">
        <div v-for="activity in activities" :key="activity.id" class="card m-3">
          <p class="m-0 p-3 font-weight-bold">{{ activity.name }}</p>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Дата</th>
                <th scope="col" class="w-50">Статус</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="dayActivity in activity.day_activities" :key="dayActivity.id">
                <td>{{ dayActivity.date }}</td>
                <td v-if="dayActivity.is_free_day"><span class="alert alert-warning">Выходной</span></td>
                <td v-else-if="dayActivity.is_done"><span class="alert alert-success">Сделано</span></td>
                <td v-else><span class="alert alert-danger">Не сделано</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

const today = new Date();
today.setHours(0, 0, 0, 0);

export default {
  components: { DatePicker },
  name: "History",
  data() {
    return {
      activities: [],
      startDate: today,
      endDate: today,
    }
  },
  methods:{
    getFormatedDate(date){
      const dd = String(date.getDate()).padStart(2, '0');
      const mm = String(date.getMonth() + 1).padStart(2, '0');
      const yyyy = date.getFullYear();
      return `${yyyy}-${mm}-${dd}`;
    },
    fetchHistory() {
      this.$store.dispatch('dayActivities/fetchActivities', {
        startDate: this.getFormatedDate(this.startDate), 
        endDate: this.getFormatedDate(this.endDate)
        }).then(
        () => {
            if (this.hasError) {
                console.log(this.error)
            } else {
              this.activities = this.dayActivitesFromStore
            }
        }
      );
    },
    notAfterToday(date) {
      return date > today;
    },
    notAfterEndDate(date) {
      return date > this.endDate || this.endDate == date ;
    },
  },
  computed: {
      isAuthenticated() {
          return this.$store.getters['auth/isAuthenticated'];
      },
      // isAdmin() {
      //     return this.$store.getters['user/hasRole']('ROLE_ADMIN');
      // },
      hasError() {
          return this.$store.getters['dayActivities/hasError'];
      },
      error() {
          return this.$store.getters['dayActivities/error'];
      },
      dayActivitesFromStore() {
          return this.$store.getters['dayActivities/getDayActivities']
      },
      isDayActivitiesLoading() {
          return this.$store.getters['dayActivities/isDayActivitiesLoading']
      },
      isDayActivityUpdating() {
          return this.$store.getters['dayActivities/isDayActivityUpdating']
      }
  },
}
</script>

<style>

</style>