import axios from 'axios';

export const getPeopleById = async (id) => {
    const response = await axios.get(`/api/v1/people/${id}`);
    return response.data;
};
