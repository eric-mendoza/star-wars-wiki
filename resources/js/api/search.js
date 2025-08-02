import axios from 'axios';

/**
 * Search for movies or people which contain the 'term' in their title or name.
 * @param term
 * @param type
 * @returns {Promise<any>}
 */
export const search = async (term, type) => {
    const response = await axios.get(`/api/v1/search`, {
        params: { term, type },
    });
    return response.data;
};
