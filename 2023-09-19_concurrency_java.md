## concurrency_java


i    Thread class: The Thread class is the most basic way to create a thread in Java. It provides a simple interface for creating and managing threads. To create a thread using the Thread class, you need to create a new instance of the Thread class and then call the start() method on the instance. The start() method will start the thread running.

The Thread class also provides a number of methods for managing threads, such as the join() method, which will wait for the thread to finish running, and the sleep() method, which will pause the thread for a specified amount of time.

    Runnable interface: The Runnable interface is a more powerful way to create a thread in Java. It provides a way to create a thread that performs a task that is defined by a separate class. To create a thread using the Runnable interface, you need to create a new class that implements the Runnable interface and then override the run() method in the class. The run() method is where you will define the task that the thread will perform.

To create a thread using the Runnable interface, you need to create a new instance of the Thread class and then pass an instance of the class that implements the Runnable interface to the constructor of the Thread class. The start() method will then start the thread running.

    Callable interface: The Callable interface is another powerful way to create a thread in Java. It provides a way to create a thread that returns a value. To create a thread using the Callable interface, you need to create a new class that implements the Callable interface and then override the call() method in the class. The call() method is where you will define the task that the thread will perform.

To create a thread using the Callable interface, you need to create a new instance of the ExecutorService class and then call the submit() method on the instance, passing an instance of the class that implements the Callable interface to the method. The submit() method will return a Future object, which you can use to get the value that the thread returns.

    ExecutorService: The ExecutorService class is a powerful way to create and manage a pool of threads. It provides a number of methods for creating and managing threads, such as the submit() method, which will submit a task to the pool, and the awaitTermination() method, which will wait for all of the tasks in the pool to finish running.

The ExecutorService class is a good choice when you need to create a pool of threads that can be reused. For example, if you need to create a pool of threads that will download images from the internet, you can use the ExecutorService class to create the pool of threads and then submit the download tasks to the pool. The ExecutorService class will take care of creating and managing the threads, and you can focus on writing the code that performs the downloads.

    ForkJoinPool: The ForkJoinPool class is a specialized type of ExecutorService that is designed for performing a large number of small, independent tasks. It is very efficient at using resources, and it can be used to perform tasks such as sorting a large array or searching for a value in a large database.
    CompletableFuture: The CompletableFuture class is a powerful class that provides a way to create and manage a future that represents the completion of a task. It can be used to coordinate the execution of multiple tasks, and it provides a number of methods for getting the result of a task, checking the status of a task, and waiting for a task to finish.

The CompletableFuture class is a good choice when you need to coordinate the execution of multiple tasks. For example, if you need to download an image and then resize it, you can use the CompletableFuture class to coordinate the execution of the download task and the resize task. The CompletableFuture class will take care of making sure that the tasks are executed in the correct order, and it will provide you with a way to get the result of the tasks.
What happens when you provide more tasks than the threads can handle?

If you provide more tasks than the threads can handle, the threads will start to queue up. The first thread will start running, and when it finishes, the next thread in the queue will start running. This will continue until all of the tasks have been completed.

The number of tasks that a thread can handle depends on a number of factors, such as the complexity of the tasks, the amount of memory that the tasks use, and the amount of CPU time that the tasks require.

If you are providing more tasks than the threads can handle, you may want to consider using a thread pool. A thread pool is a group of threads that are managed by the Java runtime environment. When you submit a task to a thread pool, the thread pool will start a new thread to execute the task. If there are no available threads in the pool, the task will be queued up. When a thread becomes available, the task will be executed.

Thread pools can help to improve the performance of your application by ensuring that there are always threads available to execute tasks. They can also help to improve the scalability of your application by allowing you to handle more tasks without having to create more threads.

Let’s say you have an application that is downloading images from the internet. You could use a single thread to download the images, but this would be very slow. Instead, you could use multiple threads to download the images. This would speed up the download process because the images could be downloaded in parallel. However, if you use too many threads, you could actually slow down the download process. This is because each thread would need to share the CPU and memory resources on the computer. If there are not enough CPU and memory resources available, the threads will start to compete for resources, which will slow down the download process.
Managing queue size for each method

Managing queue size can be crucial in multithreading to prevent resource starvation and overload. Here are some ways to manage queue size in different threading approaches:

1.Thread Class: The Thread class has no built-in support for queue size management. However, you can manually manage the queue size by implementing a bounded buffer or using a BlockingQueue to limit the number of tasks that can be submitted to a thread at a time.

2. Runnable Interface: Similar to the Thread class, the Runnable interface has no built-in support for queue size management. However, you can manually manage the queue size as mentioned above.

class BoundedBuffer {
    private int[] buffer;
    private int size, count, head, tail;

    public BoundedBuffer(int size) {
        buffer = new int[size];
        this.size = size;
        count = 0;
        head = 0;
        tail = 0;
    }

    public synchronized void put(int value) throws InterruptedException {
        while (count == size) {
            wait();
        }
        buffer[tail] = value;
        tail = (tail + 1) % size;
        count++;
        notifyAll();
    }

    public synchronized int take() throws InterruptedException {
        while (count == 0) {
            wait();
        }
        int value = buffer[head];
        head = (head + 1) % size;
        count--;
        notifyAll();
        return value;
    }
}

class Task implements Runnable {
    private BoundedBuffer queue;

    public Task(BoundedBuffer queue) {
        this.queue = queue;
    }

    public void run() {
        try {
            int value = queue.take();
            // process the value
        } catch (InterruptedException e) {
            Thread.currentThread().interrupt();
        }
    }
}

public class Main {
    public static void main(String[] args) {
        int numTasks = 1000;
        BoundedBuffer queue = new BoundedBuffer(100);

        for (int i = 0; i < numTasks; i++) {
            Runnable task = new Task(queue);
            new Thread(task).start();
        }
    }
}

To catch unhandled exceptions in threads, 
you can also use Thread.UncaughtExceptionHandler like this:

Thread thread = new Thread(new MyRunnable());
thread.setUncaughtExceptionHandler(new Thread.UncaughtExceptionHandler() {
    @Override
    public void uncaughtException(Thread t, Throwable e) {
        // handle the uncaught exception
    }
});
thread.start();

3. Callable Interface: The Callable interface can be used with an ExecutorService to submit a task to a thread pool. You can create an ExecutorService with a fixed thread pool size and a bounded blocking queue to limit the number of tasks that can be submitted to the thread pool. This way, once the queue is full, the new tasks will wait until there is room in the queue.

import java.util.concurrent.*;

public class CallableExample {
    public static void main(String[] args) {
        int numThreads = 4;
        BlockingQueue<Future<String>> queue = new LinkedBlockingQueue<>(numThreads);

        ExecutorService executorService = Executors.newFixedThreadPool(numThreads);

        for (int i = 0; i < numThreads; i++) {
            Future<String> future = executorService.submit(new Task());
            queue.add(future);
        }

        while (!queue.isEmpty()) {
            try {
                Future<String> future = queue.take();
                String result = future.get();
                System.out.println(result);
            } catch (InterruptedException | ExecutionException e) {
                System.err.println("Error occurred while executing task: " + e.getMessage());
            }
        }

        executorService.shutdown();
    }

    private static class Task implements Callable<String> {
        @Override
        public String call() throws Exception {
            // Your code to execute the task
            return "Task completed successfully";
        }
    }
}

4. ExecutorService: The ExecutorService provides a built-in queue to manage the task queue size. You can set the queue size using the BlockingQueue parameter when creating an ExecutorService instance. The default implementation of the BlockingQueue is an unbounded queue, which can lead to memory issues if too many tasks are submitted. Important functions

    setCorePoolSize(): This method sets the minimum number of threads that are always kept in the pool, even if there are no tasks to be executed.
    setMaximumPoolSize(): This method sets the maximum number of threads that can be in the pool at any given time.
    getCorePoolSize(): This method gets the minimum number of threads that are always kept in the pool, even if there are no tasks to be executed.
    getMaximumPoolSize(): This method gets the maximum number of threads that can be in the pool at any given time.
    getQueue(): This method gets the queue that is used to store the tasks that are waiting to be executed.

    Also read about ThreadPoolExecutorFactoryBean, ThreadPoolTaskScheduler, and ScheduledExecutorFactoryBean.

import org.springframework.core.task.TaskExecutor;

public class MyTaskExecutor implements TaskExecutor {

    private final ThreadPoolTaskExecutor executor;

    public MyTaskExecutor() {
        executor = new ThreadPoolTaskExecutor();
        executor.setCorePoolSize(10);
        executor.setMaxPoolSize(100);
        executor.setQueueCapacity(25);
        executor.setThreadNamePrefix("MyThread-");
        executor.initialize();
    }

    @Override
    public void execute(Runnable task) {
        executor.execute(task);
    }

}
//To use MyTaskExecutor
private ThreadPoolTaskExecutor myTaskExecutor;

public void someMethod() {
    myTaskExecutor.execute(new Runnable() {
        @Override
        public void run() {
            // Do some work here
        }
    });
}

Some corner cases that we need to be aware of while using an executor service:

    Task dependency: If the tasks are dependent on each other, we need to ensure that they are executed in the right order. For example, if we have two tasks A and B, where B is dependent on A, we need to ensure that A is executed before B.
    Task timeouts: We need to handle cases where a task may take too long to complete. We can set a timeout value for the tasks to ensure that they do not run indefinitely.
    Task exceptions: We need to handle cases where a task may throw an exception. We can use a try-catch block to catch the exception and handle it appropriately.
    Task cancellation: We need to handle cases where a task may need to be cancelled. We can use the Future interface to cancel a task.
    Resource management: We need to ensure that the executor service does not consume too many resources such as memory, CPU, or network bandwidth. We can set limits on the number of threads or the size of the thread pool to manage resource usage.
    Deadlock: We need to be careful while implementing tasks that may lead to a deadlock situation. For example, if two tasks are waiting for each other to complete, it can lead to a deadlock. We can avoid this by using a timeout or a timeout handler.
    Thread safety: We need to ensure that the tasks and the resources accessed by them are thread-safe. For example, if two tasks are accessing the same resource concurrently, it may lead to data corruption or other issues.

Some ways to handle variuos corner cases:

RejectedExecutionException: 
This occurs when the ExecutorService's task queue is full 
and cannot accept any more tasks. To handle this, 
you can catch the exception and either retry the task later 
or notify the user that the task could not be executed.

try {
    executorService.submit(task);
} catch (RejectedExecutionException e) {
    // Handle the exception
}

TimeoutException: 
This occurs when a task exceeds its timeout period before it is completed.

try {
    Future<T> future = executorService.submit(task);
    T result = future.get(1, TimeUnit.SECONDS);
} catch (TimeoutException e) {
    // Handle the exception
}

ExecutionException: 
This occurs when an exception is thrown while executing a task.

try {
    Future<T> future = executorService.submit(task);
    T result = future.get();
} catch (ExecutionException e) {
    // Handle the exception
}

5. ForkJoinPool: The ForkJoinPool class has built-in support for queue size. management. You can set the maximum queue size using the ForkJoinPool.ForkJoinWorkerThreadFactory class. The default queue size is unbounded, which can lead to memory issues if too many tasks are submitted.

    setParallelism(): This method sets the number of threads that are used to execute tasks in the pool.
    getParallelism(): This method gets the number of threads that are used to execute tasks in the pool.
    getQueue(): This method gets the queue that is used to store the tasks that are waiting to be executed.

import java.util.concurrent.*;

public class ForkJoinPoolExample {
    public static void main(String[] args) {
        
        // Create a ForkJoinPool with parallelism level 4
        ForkJoinPool forkJoinPool = new ForkJoinPool(4);

        // Submit a task to the ForkJoinPool
        forkJoinPool.submit(() -> {
            // Task implementation goes here
        });

        // Get the parallelism level of the ForkJoinPool
        int parallelismLevel = forkJoinPool.getParallelism();
        System.out.println("Parallelism level: " + parallelismLevel);

        // Set the parallelism level of the ForkJoinPool to 2
        forkJoinPool.setParallelism(2);
        parallelismLevel = forkJoinPool.getParallelism();
        System.out.println("New parallelism level: " + parallelismLevel);

        // Get the task queue of the ForkJoinPool
        ForkJoinPool.ForkJoinWorkerThreadFactory threadFactory = forkJoinPool.getFactory();
        ForkJoinPool.ForkJoinWorkerThread workerThread = threadFactory.newThread(forkJoinPool);
        ForkJoinPool.WorkQueue queue = workerThread.workQueue;
        System.out.println("Task queue size: " + queue.getQueuedTaskCount());
    }
}

There are other ways to implement the ForkJoin pool in Java, such as:

    Using the ForkJoinTask interface: This interface represents a task that can be executed asynchronously in the ForkJoin pool. You can create a class that implements this interface and override the compute() method to define the task that needs to be executed.
    Using the RecursiveTask and RecursiveAction classes: These classes extend the ForkJoinTask class and provide additional methods to define tasks that need to be executed recursively. RecursiveTask returns a result, while RecursiveAction does not.
    Using the ManagedBlocker interface: This interface provides a way to block the current thread until a task is completed. It can be used to implement non-ForkJoin tasks that need to be executed in the ForkJoin pool.

import java.util.concurrent.*;

//Using ForkJoinTask
public class MyTask extends RecursiveAction {
    private int start, end;

    public MyTask(int start, int end) {
        this.start = start;
        this.end = end;
    }

    protected void compute() {
        if ((end - start) < 100) {
            for (int i = start; i < end; i++) {
                // Perform some operation
            }
        } else {
            int mid = (start + end) / 2;
            invokeAll(new MyTask(start, mid), new MyTask(mid, end));
        }
    }

    public static void main(String[] args) {
        ForkJoinPool pool = new ForkJoinPool();
        MyTask task = new MyTask(0, 1000);
        pool.invoke(task);
    }
}

//Using RecursiveTask
public class MyTask extends RecursiveTask<Integer> {
    private int start, end;

    public MyTask(int start, int end) {
        this.start = start;
        this.end = end;
    }

    protected Integer compute() {
        if ((end - start) < 100) {
            int sum = 0;
            for (int i = start; i < end; i++) {
                sum += i;
            }
            return sum;
        } else {
            int mid = (start + end) / 2;
            MyTask task1 = new MyTask(start, mid);
            MyTask task2 = new MyTask(mid, end);
            task1.fork();
            int result2 = task2.compute();
            int result1 = task1.join();
            return result1 + result2;
        }
    }

    public static void main(String[] args) {
        ForkJoinPool pool = new ForkJoinPool();
        MyTask task = new MyTask(0, 1000);
        int result = pool.invoke(task);
        System.out.println(result);
    }
}

//Using RecursiveAction and custom ForkJoinWorkerThreadFactory
public class MyTask extends RecursiveAction {
    private int start, end;

    public MyTask(int start, int end) {
        this.start = start;
        this.end = end;
    }

    protected void compute() {
        if ((end - start) < 100) {
            for (int i = start; i < end; i++) {
                // Perform some operation
            }
        } else {
            int mid = (start + end) / 2;
            invokeAll(new MyTask(start, mid), new MyTask(mid, end));
        }
    }

    public static void main(String[] args) {
        ForkJoinWorkerThreadFactory factory = new ForkJoinWorkerThreadFactory() {
            public ForkJoinWorkerThread newThread(ForkJoinPool pool) {
                return new MyWorkerThread(pool);
            }
        };
        ForkJoinPool pool = new ForkJoinPool(4, factory, null, false);
        MyTask task = new MyTask(0, 1000);
        pool.invoke(task);
    }

    private static class MyWorkerThread extends ForkJoinWorkerThread {
        protected MyWorkerThread(ForkJoinPool pool) {
            super(pool);
        }
    }
}

6. CompletableFuture: CompletableFuture uses the same executor service as the ForkJoinPool. You can use a custom executor service with a bounded blocking queue to limit the number of tasks that can be submitted to the CompletableFuture. Below is the example for bounded and unbounded implementation.

import java.util.concurrent.*;

//Bounded queue
public class BoundedCompletableFutureExample {
    private static final int THREAD_POOL_SIZE = 4;
    private static final int QUEUE_SIZE = 10;
    private static final ExecutorService executor = new ThreadPoolExecutor(
            THREAD_POOL_SIZE, THREAD_POOL_SIZE, 0L, TimeUnit.MILLISECONDS,
            new ArrayBlockingQueue<>(QUEUE_SIZE), new ThreadPoolExecutor.CallerRunsPolicy());

    public static void main(String[] args) {
        CompletableFuture<String> future = CompletableFuture.supplyAsync(() -> {
            // Some long-running operation
            return "Hello";
        }, executor).thenApplyAsync(result -> {
            // Some other long-running operation
            return result + " World!";
        }, executor);

        String result = null;
        try {
            result = future.get();
        } catch (InterruptedException | ExecutionException e) {
            e.printStackTrace();
        }

        System.out.println(result);
        executor.shutdown();
    }
}

//Unbounded queue
public class UnboundedCompletableFutureExample {
    private static final int THREAD_POOL_SIZE = 4;
    private static final ExecutorService executor = Executors.newFixedThreadPool(THREAD_POOL_SIZE);

    public static void main(String[] args) {
        CompletableFuture<String> future = CompletableFuture.supplyAsync(() -> {
            // Some long-running operation
            return "Hello";
        }, executor).thenApplyAsync(result -> {
            // Some other long-running operation
            return result + " World!";
        }, executor);

        String result = null;
        try {
            result = future.get();
        } catch (InterruptedException | ExecutionException e) {
            e.printStackTrace();
        }

        System.out.println(result);
        executor.shutdown();
    }
}

When to use a bounded queue and when to use an unbounded queue depends on the specific requirements of your application. If memory usage is a concern, a bounded queue can help to limit the amount of memory used by your program. However, if you need to submit an unlimited number of tasks to the executor, an unbounded queue may be a better option.

