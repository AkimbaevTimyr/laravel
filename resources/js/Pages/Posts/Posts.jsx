import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link} from "@inertiajs/react";
import Post from "@/Pages/Posts/Post.jsx";

export default function Posts({ auth, posts, role}){
    console.log(posts)
    return(
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>}
        >
            <Head title="Posts" />

            <div className="py-14">
                {posts.length === 0 ? <div className="py-12">
                                            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                                    <div className="p-6 text-gray-900">Posts not found!</div>
                                                </div>
                                            </div>
                                        </div>
                    :
                    posts.map((item) => (
                    <Link href={`/post-edit/${item.id}`} key={item.id}>
                        <Post id={item.id} author={item.author} title={item.title} description={item.description} path={item.path} created_at={item.created_at} showDeleteButton={false}/>
                    </Link>
                ))}
            </div>
        </AuthenticatedLayout>
    )
}
