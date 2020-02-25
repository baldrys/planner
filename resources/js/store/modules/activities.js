import ActivitiesApi from '../../api/Activities';
import axios from 'axios'

const FETCHING_ACTIVITIES = "FETCHING_ACTIVITIES";
const FETCHING_ACTIVITIES_SUCCESS = "FETCHING_ACTIVITIES_SUCCESS";
const FETCHING_ACTIVITIES_ERROR = "FETCHING_ACTIVITIES_ERROR";
const UPDATING_ACTIVITY = "UPDATING_ACTIVITY";
const UPDATING_ACTIVITY_SUCCESS = "UPDATING_ACTIVITY_SUCCESS";
const UPDATING_ACTIVITY_ERROR = "UPDATING_ACTIVITY_ERROR";
const DELETING_ACTIVITY = "DELETING_ACTIVITY";
const DELETING_ACTIVITY_SUCCESS = "DELETING_ACTIVITY_SUCCESS";
const DELETING_ACTIVITY_ERROR = "DELETING_ACTIVITY_ERROR";
const ADDING_ACTIVITY = "ADDING_ACTIVITY";
const ADDING_ACTIVITY_SUCCESS = "ADDING_ACTIVITY_SUCCESS";
const ADDING_ACTIVITY_ERROR = "ADDING_ACTIVITY_ERROR";

const getDefaultState = () => {
    return {
        activities: [],
        error: null,
        isActivitiesLoading: false,
        isActivityUpdating: false,
        isActivityDeleting: false,
        isActivityAdding: false,
    }
}

const mutations = {
    [FETCHING_ACTIVITIES](state) {
        state.isActivitiesLoading = true;
        state.error = null;
    },
    [FETCHING_ACTIVITIES_SUCCESS](state, activities) {
        state.error = null;
        state.isActivitiesLoading = false;
        state.activities = activities
    },
    [FETCHING_ACTIVITIES_ERROR](state, error) {
        state.error = error;
        state.isActivitiesLoading = false
    },
    [UPDATING_ACTIVITY](state) {
        state.isActivityUpdating = true;
        state.error = null;
    },
    [UPDATING_ACTIVITY_SUCCESS](state, activity) {
        state.error = null;
        state.isActivityUpdating = false;
        const index =  state.activities.findIndex(a => a.id === activity.id)
        state.activities[index] = activity;
    },
    [UPDATING_ACTIVITY_ERROR](state, error) {
        state.error = error;
        state.isActivityUpdating = false
    },
    [ADDING_ACTIVITY](state) {
        state.isActivityAdding = true;
        state.error = null;
    },
    [ADDING_ACTIVITY_SUCCESS](state, activity) {
        state.error = null;
        state.isActivityAdding = false;
        state.activities.push(activity);
    },
    [ADDING_ACTIVITY_ERROR](state, error) {
        state.error = error;
        state.isActivityAdding = false
    },
    [DELETING_ACTIVITY](state) {
        state.isActivityDeleting = true;
        state.error = null;
    },
    [DELETING_ACTIVITY_SUCCESS](state, activity) {
        state.error = null;
        state.isActivityDeleting = false;
        const index =  state.activities.findIndex(a => a.id === activity.id)
        state.activities.splice(index, 1);
    },
    [DELETING_ACTIVITY_ERROR](state, error) {
        state.error = error;
        state.isActivityDeleting = false
    },
};

const actions = {
    async fetchActivities({ commit }) {
        commit(FETCHING_ACTIVITIES);
        try {
            const response = await ActivitiesApi.fetchActivities();
            const activities = response.data.data;
            commit(FETCHING_ACTIVITIES_SUCCESS, activities);
            return response.data.data;
        } catch (error) {
            commit(FETCHING_ACTIVITIES_ERROR, error);
            return null;
        }
    },
    async updateActivity({ commit }, payload) {
        commit(UPDATING_ACTIVITY);
        try {
            const response = await ActivitiesApi.updateActivity(payload);
            const activity = response.data.data;
            commit(UPDATING_ACTIVITY_SUCCESS, activity);
            return response.data.data;
        } catch (error) {
            commit(UPDATING_ACTIVITY_ERROR, error);
            return null;
        }
    },
    async deleteActivity({ commit }, payload) {
        commit(DELETING_ACTIVITY);
        try {
            const response = await ActivitiesApi.deleteActivity(payload);
            commit(DELETING_ACTIVITY_SUCCESS, payload);
            return response.data.data;
        } catch (error) {
            commit(DELETING_ACTIVITY_ERROR, error);
            return null;
        }
    },
    async addActivity({ commit }, payload) {
        commit(ADDING_ACTIVITY);
        try {
            const response = await ActivitiesApi.addActivity(payload);
            const addedActivity = response.data.data;
            commit(ADDING_ACTIVITY_SUCCESS, addedActivity);
            return response.data.data;
        } catch (error) {
            commit(ADDING_ACTIVITY_ERROR, error);
            return null;
        }
    },
};

const getters = {
    hasError(state) {
        return state.error !== null;
    },
    error(state) {
        return state.error;
    },
    isActivitiesLoading(state) {
        return state.isActivitiesLoading;
    },
    isActivityUpdating(state) {
        return state.isActivityUpdating;
    },
    isActivityDeleting(state) {
        return state.isActivityDeleting;
    },
    isActivityAdding(state) {
        return state.isActivityAdding;
    },
    getActivities(state) {
        return state.activities;
    }
};

export default {
    namespaced: true,
    state: getDefaultState(),
    getters,
    actions,
    mutations,
}