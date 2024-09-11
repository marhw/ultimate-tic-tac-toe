export class APIError extends Error {
  constructor(public readonly message: string, public readonly status: number) {
    super(message);
  }
}

async function handleFetchReq(req: () => Promise<any>) {
  try {
    const response = await req();
    if (!response.ok) {
      return new APIError(response.statusText, response.status);
    }

    return await response.json()
  } catch (error) {
    return error as Error;
  }
}

function prepareHeaders() {
  const headers = new Headers();
  headers.append("Content-Type", "application/json");

  return headers;
}

async function getReq<TResult>(url: string): Promise<TResult | APIError | Error> {
  return handleFetchReq(() => fetch(url, {headers: prepareHeaders()}));
}

async function postReq<TResult, TBody>(url: string, body: TBody): Promise<TResult | APIError | Error> {
  return handleFetchReq(() => fetch(url, {method: 'POST', body: JSON.stringify(body), headers: prepareHeaders()}));
}

async function deleteReq<TResult>(url: string): Promise<TResult | APIError | Error> {
  return handleFetchReq(() => fetch(url, {method: 'DELETE', headers: prepareHeaders()}));
}

export function useApi() {
  return {
    getReq,
    postReq,
    deleteReq,
  }
}