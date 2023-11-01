import { Link, Head, useForm } from '@inertiajs/react';
import axios from 'axios';
import { useState } from 'react';
import Pagination from '@/Components/Pagination';
import ImageComponent from "@/Components/ImageComponent.jsx";
import { convertDate } from "@/helpers/converDate.js";

import Post from './Posts/Post';

export default function Welcome({ auth,posts, authors }) {

    const [data, setData] = useState(posts.data);
    const [links, setLinks] = useState(posts.links)

    const handleSelect = (e) => {
        let id = e.target.value;
        axios.get(`/posts-filter/${id}`).then((resp) => {
            setData(resp.data.data);
            setLinks(resp.data.links)
        })
    }

    return (
        <>
            <Head title="Welcome" />
            <div className="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
                <div className="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    {auth.user ? (
                        <Link
                            href={route('dashboard')}
                            className="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                        >
                            Dashboard
                        </Link>
                    ) : (
                        <>
                            <Link
                                href={route('login')}
                                className="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                            >
                                Log in
                            </Link>

                            <Link
                                href={route('register')}
                                className="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                            >
                                Register
                            </Link>

                        </>
                    )}
                </div>

                <div className="max-w-7xl mx-auto p-6 lg:p-8 flex items-center flex-col">

                    <div className="flex justify-center align-items-center">
                        <label>Отфильтровать посты</label>
                        <select onClick={(e) => handleSelect(e)} className="form-select ml-5" aria-label="Default select example">
                            <option value='0' key="0" selected>Все</option>
                            {authors.map((author) => (
                                <option key={author.id} value={author.id}>{author.name}</option>
                            ))}
                        </select>
                    </div>

                    <div className="mt-16">
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                            {data.length != 0 ? data.map((post) => (
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
                            )) : 'Посты не найдены'}
                        </div>
                    </div>

                    <Pagination links={links} />
                </div>
            </div>
        </>
    );
}
