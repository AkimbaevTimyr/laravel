import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { useForm } from '@inertiajs/react';
import TextInput from '@/Components/TextInput';
import PrimaryButton from '@/Components/PrimaryButton';
import InputLabel from '@/Components/InputLabel';

export default function Roles({auth, roles, users}){
    const {put, data, setData, processing, post} = useForm({
        role: "",
        permission: ""
    });

    const onHandleChange = (e, id) => {
        const role_id = e.target.value
        put(`/update-role/${id}/${role_id}`);
    }

    const submit = (e) => {
        e.preventDefault();
        post('/create-role');
    }

    return(
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Управление ролями</h2>}
        >

            <div className="py-14">
                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                        <div className="mt-2">
                            <table className="mx-auto table-auto">
                                <thead>
                                <tr className="bg-gradient-to-r from-indigo-600 to-purple-600">
                                    <th className="px-16 py-2">
                                        <span className="text-gray-100 font-semibold">Name</span>
                                    </th>
                                    <th className="px-16 py-2">
                                        <span className="text-gray-100 font-semibold">Email</span>
                                    </th>

                                    <th className="px-16 py-2">
                                        <span className="text-gray-100 font-semibold">Role</span>
                                    </th>

                                    <th className="px-16 py-2">
                                        <span className="text-gray-100 font-semibold">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody className="bg-gray-200">
                                    {
                                        users.map((user) => (
                                            <tr key={user.id} className="bg-white border-b-2 border-gray-200">
                                                <td>
                                                    <span className="text-center ml-2 font-semibold">{user.name}</span>
                                                </td>
                                                <td className="px-16 py-2">
                                                    <span>{user.email}</span>
                                                </td>
                                                <td className="px-16 py-2">
                                                    <span>{user.role}</span>
                                                </td>
                                                <td className="px-16 py-2">
                                                <select name="select" id="select" onChange={(e) => onHandleChange(e, user.id)} disabled={user.email == auth.user.email}>
                                                    {
                                                        roles.map((role) => (
                                                            <option key={role.id} value={role.id} selected={role.name === user.role}>{role.name}</option>
                                                        ))
                                                    }
                                                </select>
                                                </td>
                                            </tr>
                                        ))
                                    }
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div className="max-w-5xl mx-auto sm:px-6 lg:px-8 ">
                        <div className="mt-2">
                        <form onSubmit={submit}>
                            <div>
                                <InputLabel htmlFor="role" value="Role" />

                                <TextInput
                                    id="role"
                                    type="role"
                                    name="role"
                                    value={data.email}
                                    className="mt-1 block w-full"
                                    autoComplete="username"
                                    isFocused={true}
                                    onChange={(e) => setData('role', e.target.value)}
                                />

                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="permission" value="Permission" />

                                <TextInput
                                    id="permission"
                                    type="permission"
                                    name="permission"
                                    value={data.password}
                                    className="mt-1 block w-full"
                                    autoComplete="current-password"
                                    onChange={(e) => setData('permission', e.target.value)}
                                />

                            </div>

                            <div className="flex items-center justify-end mt-4 mb-5">
                                <PrimaryButton className="ml-4" disabled={processing}>
                                    Создать
                                </PrimaryButton>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}