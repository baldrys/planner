<template>
    <div class="container">
        <div class="pt-3 border-bottom">
            <h1 class="h2">Список активностей на сегодня</h1>
            <div v-if="isDayActivitiesLoading" class="spinner-border spinner"></div>
            <table v-else class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Активность</th>
                    <th scope="col" class="w-50">Статус</th>
                    </tr>
                </thead>
                <tbody v-if="dayActivites.day_activities">
                    <tr v-for="(dayActivity, dayActivityId) in dayActivites" :key="dayActivity.id">
                        <th scope="row">{{ parseInt(dayActivityId) + 1 }}</th>
                        <td>{{ dayActivity.name }}</td>
                        <td v-if="dayActivity.day_activities[0].is_free_day" class="d-flex"><div class="mb-0 mr-1 alert alert-warning">Выходной</div></td>
                        <td v-else-if="!dayActivity.day_activities[0].is_done" class="d-flex">
                            <div class="mb-0 mr-1 alert alert-danger">Не сделано</div>
                            <button @click="activityDone(dayActivity.day_activities[0].id)" class="btn btn-success btn-sm">
                                <span v-if="isDayActivityUpdating && dayActivityActed.id == dayActivity.day_activities[0].id" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Готово!
                            </button>
                        </td>
                        <td v-else class="d-flex">
                            <div class="mb-0 mr-1 alert alert-success">
                            Уже сделано!
                            </div>
                            <button @click="activityUndo(dayActivity.day_activities[0].id)" class="btn btn-danger btn-sm">
                                <span v-if="isDayActivityUpdating && dayActivityActed.id == dayActivity.day_activities[0].id" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Отменить
                            </button>
                        </td>
                    </tr>
                </tbody>
                </table>
        </div> 
    </div>
   
</template>

<script>
    export default {
        data() {
            return {
                dayActivityActed:{
                    id: ''
                }
            }
        },
        name: "Home",
        created() {
            // получаем сегодняющню дату
            const todayDate = this.getTodayDate();
            this.$store.dispatch('dayActivities/fetchActivities', {startDate: todayDate, endDate: todayDate}).then(
                () => {
                    if (this.hasError) {
                        console.log(this.error)
                    }
                }
            );
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
            dayActivites() {
                return this.$store.getters['dayActivities/getDayActivities']
            },
            isDayActivitiesLoading() {
                return this.$store.getters['dayActivities/isDayActivitiesLoading']
            },
            isDayActivityUpdating() {
                return this.$store.getters['dayActivities/isDayActivityUpdating']
            }
        },
        methods:{
            getTodayDate(){
                const today = new Date();
                const dd = String(today.getDate()).padStart(2, '0');
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const yyyy = today.getFullYear();
                return `${yyyy}-${mm}-${dd}`;
            },
            activityDone(id){
                this.dayActivityActed.id = id;
                this.$store.dispatch('dayActivities/updateDayActivity', {isDone: 1, id: id}).then(
                    () => {
                        if (this.hasError) {
                            console.log(this.error)
                        }
                    }
                );
            },
            activityUndo(id) {
                this.$store.dispatch('dayActivities/updateDayActivity', {isDone: 0, id: id}).then(
                    () => {
                        if (this.hasError) {
                            console.log(this.error)
                        }
                    }
                );  
            }
        }
    }
</script>

<style>


</style>