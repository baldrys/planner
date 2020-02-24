import axios from 'axios';

const userId = localStorage.getItem('user_id');
const DAY_ACTIVITIES_URL = `/api/users/${userId}/day-activities`;

export default {
    fetchDayActivities(dates) {
        return axios.get(DAY_ACTIVITIES_URL, {
            params: {
                start_date: dates.startDate, end_date: dates.endDate
            }
        })
    },
    updateDayActivity(dayActivity) {
        return axios.patch( DAY_ACTIVITIES_URL + "/" + dayActivity.id, {is_done: dayActivity.isDone});
    }
};