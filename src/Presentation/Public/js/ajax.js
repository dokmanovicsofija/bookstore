class Ajax {
    static get(url) {
        return fetch(url)
            .then(response => response.json());
    }

    static post(url, data) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json());
    }

    static delete(url) {
        return fetch(url, {
            method: 'DELETE'
        })
            .then(response => {
                if (response.ok) {
                    if (response.status === 204) {
                        return null;
                    }
                    return response.json();
                } else {
                    return response.text().then(text => {
                        throw new Error(text || 'Network response was not ok');
                    });
                }
            });
    }
}
