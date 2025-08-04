import axios from 'axios';

export const getMovieById = async (id) => {
    const response = await axios.get(`/api/v1/movies/${id}`);
    return response.data;
};
