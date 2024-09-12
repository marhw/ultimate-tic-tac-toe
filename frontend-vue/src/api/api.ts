const apiUrl = import.meta.env.VITE_API_URL

export class APIError extends Error {
    constructor(
        public readonly message: string,
        public readonly status: number
    ) {
        super(message)
    }
}

async function handleFetchReq(req: () => Promise<Response>) {
    try {
        const response = await req()
        if (!response.ok) {
            return new APIError(response.statusText, response.status)
        }

        return await response.json()
    } catch (error) {
        return error as Error
    }
}

function prepareHeaders() {
    const headers = new Headers()
    headers.append('Content-Type', 'application/json')

    return headers
}

function withBaseUrl(url: string): string {
    return `${apiUrl}${url}`
}

async function getReq<TResult>(
    url: string
): Promise<TResult | APIError | Error> {
    return handleFetchReq(() =>
        fetch(withBaseUrl(url), {method: 'GET', headers: prepareHeaders()})
    )
}

async function postReq<TResult, TBody>(
    url: string,
    body: TBody
): Promise<TResult | APIError | Error> {
    return handleFetchReq(() =>
        fetch(withBaseUrl(url), {
            method: 'POST',
            body: JSON.stringify(body),
            headers: prepareHeaders(),
        })
    )
}

async function deleteReq<TResult>(
    url: string
): Promise<TResult | APIError | Error> {
    return handleFetchReq(() =>
        fetch(withBaseUrl(url), {method: 'DELETE', headers: prepareHeaders()})
    )
}

export function useApi() {
    return {
        getReq,
        postReq,
        deleteReq,
    }
}
