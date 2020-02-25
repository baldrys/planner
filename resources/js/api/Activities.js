import axios from 'axios';

const userId = localStorage.getItem('user_id');
const ACTIVITIES_URL = `/api/users/${userId}/activities`;

export default {
    fetchActivities() {
        return axios.get( ACTIVITIES_URL);
    },
    updateActivity(activity) {
        return axios.patch( ACTIVITIES_URL + "/" + activity.id, {name: activity.name, activity_period:activity.activity_period});
    },
    deleteActivity(activity) {
        return axios.delete( ACTIVITIES_URL + "/" + activity.id);
    },
    addActivity(activity) {
        return axios.post( ACTIVITIES_URL, {name: activity.name , activity_period: activity.period});
    }
};