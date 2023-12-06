import { convertDate } from "@/helpers/converDate"

export default function Comment({ handleDelete, comment }) {
    return (
        <>
            <div key={comment.id} className="mb-5 flex flex-col text-center">
                <div className="flex justify-between bg-slate-50 p-5">
                    <p>{comment.name}</p>
                    <p>
                        {
                            convertDate(comment.created_at)
                        }
                    </p>
                    <button
                        type="button"
                        onClick={() => handleDelete(comment.id)}
                        className="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                    >
                        Удалить
                    </button>
                </div>
                <div className="flex flex-start mt-3">{comment.comment}</div>
            </div>
        </>
    )
}