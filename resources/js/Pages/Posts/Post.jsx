import ImageComponent from "@/Components/ImageComponent.jsx";
import {convertDate} from "@/helpers/converDate.js";

export default function Post({id, author, title, description, created_at, path, showDeleteButton}){

    return(
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div className="p-6">
                    <ImageComponent imagePath={path} />
                </div>
                <h2 className="p-6 text-lg font-medium text-gray-900">
                    {title}
                </h2>
                <div className="p-6 text-gray-900">{description}</div>
                <div className="p-6 flex items-center gap-4">
                    <p className="mt-1 text-sm text-gray-600">
                        {convertDate(created_at)}
                    </p>
                    <p className="mt-1 text-sm text-gray-600">
                         Author: {author}
                    </p>
                </div>
            </div>
        </div>
    )
}
