import axios from 'axios';



export default {
    getUrl() {
        const userId = localStorage.getItem('user_id');
        return `/api/users/${userId}/activities`;
    },
    fetchActivities() {

        return axios.get( this.getUrl());
    },
    updateActivity(activity) {
        return axios.patch( this.getUrl() + "/" + activity.id, {name: activity.name, activity_period:activity.activity_period});
    },
    deleteActivity(activity) {
        return axios.delete( this.getUrl() + "/" + activity.id);
    },
    addActivity(activity) {
        return axios.post( this.getUrl(), {name: activity.name , activity_period: activity.period});
    }
};