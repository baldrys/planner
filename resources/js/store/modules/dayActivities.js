import DayActivitiesApi from '../../api/DayActivities';
import axios from 'axios'

const FETCHING_DAY_ACTIVITIES = "FETCHING_DAY_ACTIVITIES";
const FETCHING_DAY_ACTIVITIES_SUCCESS = "FETCHING_DAY_ACTIVITIES_SUCCESS";
const FETCHING_DAY_ACTIVITIES_ERROR = "FETCHING_DAY_ACTIVITIES_ERROR";

const UPDATING_DAY_ACTIVITY = "UPDATING_DAY_ACTIVITY";
const UPDATING_DAY_ACTIVITY_SUCCESS = "UPDATING_DAY_ACTIVITY_SUCCESS";
const UPDATING_DAY_ACTIVITY_ERROR = "UPDATING_DAY_ACTIVITY_ERROR";

const getDefaultState = () => {
    return {
        dayActivities: [],
        error: null,
        isDayActivitiesLoading: false,
        isDayActivityUpdating: false
    }
}

const mutations = {
    [FETCHING_DAY_ACTIVITIES](state) {
        state.isDayActivitiesLoading = true;
        state.error = null;
    },
    [FETCHING_DAY_ACTIVITIES_SUCCESS](state, dayActivities) {
        state.error = null;
        state.isDayActivitiesLoading = false;
        state.dayActivities = dayActivities
    },
    [FETCHING_DAY_ACTIVITIES_ERROR](state, error) {
        state.error = error;
        state.isDayActivitiesLoading = false
    },
    [UPDATING_DAY_ACTIVITY](state) {
        state.isDayActivityUpdating = true;
        state.error = null;
    },
    [UPDATING_DAY_ACTIVITY_SUCCESS](state, updatedDayActivity) {
        state.error = null;
        state.isDayActivityUpdating = false;
        state.dayActivities.forEach(function(activity) {
            if(activity.day_activities[0].id == updatedDayActivity.id){
                activity.day_activities[0].is_done = updatedDayActivity.is_done;
            }
        });
    },
    [UPDATING_DAY_ACTIVITY_ERROR](state, error) {
        state.error = error;
        state.isDayActivityUpdating = false
    },
};

const actions = {
    async fetchActivities({ commit }, payload) {
        commit(FETCHING_DAY_ACTIVITIES);
        try {
            const response = await DayActivitiesApi.fetchDayActivities(payload);
            const dayActivities = response.data.data.activities;
            console.log(dayActivities);
            commit(FETCHING_DAY_ACTIVITIES_SUCCESS, dayActivities);
            return dayActivities;
        } catch (error) {
            commit(FETCHING_DAY_ACTIVITIES_ERROR, error);
            return null;
        }
    },
    async updateDayActivity({ commit }, payload) {
        commit( UPDATING_DAY_ACTIVITY);
        try {
            const response = await DayActivitiesApi.updateDayActivity(payload);
            const updatedDayActivity = response.data.data;
            commit(UPDATING_DAY_ACTIVITY_SUCCESS, updatedDayActivity);
            return updatedDayActivity;
        } catch (error) {
            commit(UPDATING_DAY_ACTIVITY_ERROR, error);
            return null;
        }
    }
};

const getters = {
    hasError(state) {
        return state.error !== null;
    },
    error(state) {
        return state.error;
    },
    isDayActivitiesLoading(state) {
        return state.isDayActivitiesLoading;
    },
    isDayActivityUpdating(state){
        return state.isDayActivityUpdating;
    },
    getDayActivities(state) {
        return state.dayActivities;
    },
};

export default {
    namespaced: true,
    state: getDefaultState(),
    getters,
    actions,
    mutations,
}