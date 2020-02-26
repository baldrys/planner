import axios from 'axios';


export default {
    getUrl() {
        const userId = localStorage.getItem('user_id');
        return `/api/users/${userId}/day-activities`;
    },
    fetchDayActivities(dates) {
        return axios.get(this.getUrl(), {
            params: {
                start_date: dates.startDate, end_date: dates.endDate
            }
        })
    },
    updateDayActivity(dayActivity) {
        return axios.patch(this.getUrl() + "/" + dayActivity.id, {is_done: dayActivity.isDone});
    }
};