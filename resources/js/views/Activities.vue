<template>
  <div class="container">
    <div v-if="isActivitiesLoading" class="spinner-border spinner"></div>
      <div class="row">
          <div class="col">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Активности</th>
                  <th scope="col">Период(дни)</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(activity, activityId) in $v.activities.$each.$iter" :key="activity.id">
                  <th scope="row">{{ activity.id }}</th>
                  <td>
                    <input type="text" class="form-control" v-model="activity.name.$model">
                    <div class="alert alert-danger" v-if="!activity.name.required">Введите имя</div>
                  </td>
                  <td>
                    <input type="text" class="form-control" v-model="activity.activity_period.$model">
                    <div class="alert alert-danger" v-if="!activity.activity_period.required">Введите период</div>  
                    <div class="alert alert-danger" v-if="!activity.activity_period.integer || !activity.activity_period.minValue">Период целое число > 0</div>  

                  </td>
                  <td>
                    <button @click="updateActivity(activity.$model)" :disabled="
                    isActivityUpdating || !activitiesChanged[activityId] || !activity.name.required || !activity.activity_period.required || !activity.activity_period.integer || !activity.activity_period.minValue
                    " type="button" class="btn btn-success">
                        <span v-if="isActivityUpdating && activityActed.id == activity.$model.id" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Изменить
                      </button>
                    <button @click="deleteActivity(activity.$model)" type="button" class="btn btn-danger">
                        <span v-if="isActivityDeleting && activityActed.id == activity.$model.id" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Удалить
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
            <div v-if="justAdded" class="alert alert-primary">Успешно добавлено</div>
            <div v-if="justEdited" class="alert alert-success">Успешно изменено</div>  
            <div v-if="justDeleted" class="alert alert-danger">Успешно удалено</div>  
            <div><a data-toggle="collapse" href="#collapseExample">Добавить активность</a></div>
            <div class="collapse"  id="collapseExample">
                <div class="form-group row">
                    <div class="col-4">
                        <label for="newPassword-input">Название</label>
                        <input v-model="activityToAdd.name" class="form-control"> 
                        <div v-if="$v.activityToAdd.period.$dirty && !$v.activityToAdd.name.required" class="alert alert-danger">Введите имя</div>                   
                    </div>
                    <div class="col-4">
                        <label for="newPassword-input">Период(дни)</label>
                        <input  v-model="activityToAdd.period" class="form-control">
                    <div class="alert alert-danger" v-if="$v.activityToAdd.period.$dirty && !$v.activityToAdd.period.required">Введите период</div>  
                    <div class="alert alert-danger" v-if="(!$v.activityToAdd.period.integer || !$v.activityToAdd.period.minValue)">Период целое число > 0</div>                  
                    </div>
                </div>
                <button @click="addActivity" :disabled="!$v.activityToAdd.name.required || !$v.activityToAdd.period.required || !$v.activityToAdd.period.integer || !$v.activityToAdd.period.minValue" type="button" class="btn btn-primary">
                  <span v-if="isActivityAdding" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Добавить
                </button>
            </div>
          </div>

      </div>
  </div>
</template>

<script>
import {required, minValue, integer} from "vuelidate/lib/validators"

export default {
  data() {
    return {
      activities: [],
      activityActed: null,
      justEdited: false,
      justAdded: false,
      justDeleted: false,
      activityToAdd:{
        name: '',
        period: ''
      }
    }
  },
  mounted() {
     this.$store.dispatch('activities/fetchActivities').then(
        () => {
            if (this.hasError) {
                console.log(this.error)
            } else {
              this.activities = JSON.parse(JSON.stringify(this.activitiesFromStore));
            }
        }
    );
  },
  computed: {
    activitiesFromStore() {
      return this.$store.getters['activities/getActivities'];
    },
    activitiesChanged() {
      console.log('activitiesChanged');
      return this.activities.map((activity, i) => {
          if(this.activitiesFromStore[i] &&  activity.name == this.activitiesFromStore[i].name && activity.activity_period == this.activitiesFromStore[i].activity_period)
            return false;
          else
            return true  
      });
    },
    isActivitiesLoading() {
        return this.$store.getters['activities/isActivitiesLoading']
    },
    isActivityUpdating() {
        return this.$store.getters['activities/isActivityUpdating']
    },
    isActivityDeleting() {
        return this.$store.getters['activities/isActivityDeleting']
    },
    isActivityAdding() {
        return this.$store.getters['activities/isActivityAdding']
    },
  },
  methods: {
    setDefaultActionStatuses() {
      this.justDeleted = false;
      this.justAdded = false;
      this.justEdited = false;
    },
    isActivityChanged(activityId) {
      console.log('isChanged')
      if(this.activities[activityId] == this.activitiesFromStore[activityId])
        return false
      return true
    },
    updateActivity(activity){
      this.setDefaultActionStatuses();
      this.activityActed = activity;
      this.$store.dispatch('activities/updateActivity', activity).then(
              () => {
                  if (this.hasError) {
                      console.log(this.error)
                  } else {
                    this.justEdited = true;
                    this.activities = JSON.parse(JSON.stringify(this.activitiesFromStore));
                  }
              }
          );
    },
    deleteActivity(activity){
      this.setDefaultActionStatuses();
      this.activityActed = activity; // ???
      this.$store.dispatch('activities/deleteActivity', activity).then(
          () => {
              if (this.hasError) {
                  console.log(this.error)
              } else {
                  this.justDeleted = true;
                  this.activities = JSON.parse(JSON.stringify(this.activitiesFromStore));
              }
          }
      );
    },
    addActivity(activity){
      this.setDefaultActionStatuses();
      this.$store.dispatch('activities/addActivity', this.activityToAdd).then(
        () => {
            if (this.hasError) {
                console.log(this.error)
            } else {
              this.justAdded = true;
                this.activityToAdd = {
                  name: '',
                  period: ''
                };
                this.activities = JSON.parse(JSON.stringify(this.activitiesFromStore));
            }
        }
      );
    }
  },
  validations: {
    activities: {
      $each: {
        name: {
          required,
        },
        activity_period: {
          required,
          integer,
          minValue: minValue(1)
        }
      }
    },
    activityToAdd:{
      name: {
        required,
      },
      period: {
        required,
        integer,
        minValue: minValue(1)}
    }
  }
}
</script>

<style>

</style>