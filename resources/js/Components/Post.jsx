import ImageComponent from "@/Components/ImageComponent.jsx";
import { convertDate } from "@/helpers/converDate.js";

export default function Post({ post }) {
    return (
        <div
            key={post.id}
            className="scale-100 flex items-center justify-center p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
        >
            <div>
                <div className=" dark:bg-red-800/20 flex items-center justify-center rounded-full">
                    <ImageComponent imagePath={post.path} />
                </div>

                <div className="flex flex-col items-center justify-center">
                    <h2 className="mt-6 text-xl font-semibold text-gray-900 dark:text-white">
                        {post.title}
                    </h2>
                    <p className="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        {
                            post.description.length >= 256 ? post.description + `...` : post.description
                        }
                    </p>
                    <p className="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-3">
                        {
                            convertDate(post.created_at)
                        }
                    </p>
                    <a href={`/publication/${post.id}`} className="mb-3">
                        <span className="bg-slate-100 hover:bg-slate-200 p-1">
                            onClick="read"
                        </span>
                    </a>
                    <a href={`/user/${post.author_id}`} >
                        <span className="bg-slate-100 hover:bg-slate-200 p-1">
                            by {post.author}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    )
}