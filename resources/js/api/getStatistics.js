import axios from 'axios';

export const getStatistics = async () => {
    const response = await axios.get('/api/v1/statistics');
    return response.data;
};
